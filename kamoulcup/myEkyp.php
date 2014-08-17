<?php
	checkAccess(1);
	checkEkyp();
	
	$getEkypQuery = $db->getArray("select po.nom as nomPoule, ek.nom, ek.logo, ek.budget, ek.presentation, ek.score from ekyp as ek, poule as po where ek.id='{$_SESSION['myEkypId']}' and ek.poule_id=po.id limit 1");
?>

	<div class="titre_page">
		<?php echo "Mon ékyp: <a href='index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}'>{$getEkypQuery[0]['nom']}</a>"; ?>
	</div>
	<?php
		$departageQuery = $db->getArray("select dv.id as dvId,dv.montant_initial,dv.montant_nouveau, date_format(dv.date_expiration,'%d/%m à %H:%i:%s') as expirDate,jo.id as joId,jo.nom,jo.prenom from departage_vente as dv, vente as ve, joueur as jo where (dv.vente_id=ve.id) and (ve.joueur_id=jo.id) and  (dv.ekyp_id='{$_SESSION['myEkypId']}') and (dv.date_expiration > now())");
		if ($departageQuery != NULL) {
			echo "<div class='sectionPage'>";
			echo "<div class='sous_titre'>Transferts en attente";
			echo "</div>";
			echo '<ul>';
			foreach ($departageQuery as $departage) {
				echo "<li>";
				echo "<a href='index.php?page=detailJoueur&joueurid={$departage['joId']}'>{$departage['prenom']} {$departage['nom']}</a>: enchère initiale: <b>{$departage['montant_initial']} Ka</b><br/>";
				if ($departage['montant_nouveau'] != NULL) {
					echo "<div class='cadre'>Surenchère envoyée: <b>{$departage['montant_nouveau']}</b></div>";
				} else {
					echo "<form action='index.php' method='POST'>";
					echo "<input type='hidden' name='departageVenteId' value='{$departage['dvId']}'/>";
					echo "Surenchère possible jusqu'au {$departage['expirDate']}<br/>";
					echo "<div class='cadre'>Montant: <input type='text' size=4 name='departageVenteMontant'/> Ka <br/> Décliner la surenchère ? <input type=\"checkbox\" name=\"decline\" value=\"1\"/> <br/> <input type='submit' value='Surench'/></div>";
					echo "<input type=\"hidden\" name=\"page\" value=\"postSurench\"/>";
					echo "</form>";
				}
				echo "</li>";
			}
			echo '</ul></div>';
		}
	?>
	<div class="sous_titre">Dernières infos</div>
	<div class='sectionPage'>
	<?php
		$infosQuery = $db->getArray("select date_format(info.date,'%d/%m %H:%i:%s') as dateInfo,info.type,info.complement_float,jo.id,jo.prenom,jo.nom,jo.club_id from info, joueur as jo where (info.ekyp_concernee_id={$_SESSION['myEkypId']} or info.ekyp_concernee_id=0) and info.joueur_concerne_id=jo.id order by info.date desc limit 30");
		if ($infosQuery == NULL) {
			echo "Pas d'infos récentes";
		} else {
			echo "<table class='tableau_horizon'>";
			foreach ($infosQuery as $info) {
				$type= traduire($info['type']);
				$club= 'les joueurs sans club';
				if ($info['club_id'] != NULL) {
					$clubQ = $db->getArray("select nom from club where id={$info['club_id']} limit 1");
					$club = $clubQ[0][0];
				}
				$texte= infotexte($info['type'],$info['id'],$info['prenom'],$info['nom'],$club,number_format(round($info['complement_float'],1),1));
				$pic = picto($info['type']);
				
				echo "<tr><td>{$info['dateInfo']}</td><td><img src='$pic'/></td><td>{$texte}</td>";
				if ($info['type'] == 'NO') {
					if (floatval($info['complement_float']) > 0) {
						$pictevol = "+{$info['complement_float']}<img src='images/arrow_up.gif'/>";
					} else {
						$pictevol = "{$info['complement_float']}<img src='images/arrow_down.gif'/>";
					}
					echo "<td>{$pictevol}</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			echo "» <a href='index.php?page=myInfos'>Voir toutes les infos</a>";
		}
	?>
	</div>
	<div class="sous_titre">Dernières enchères</div>
	<div class='sectionPage'>
	<?php
		$listEnchQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, ve.id as idVente, ek.id as idEkyp, ek.nom as nomEkyp, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin, res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, en.montant, en.exclue from joueur as jo, vente as ve, ekyp as ek, resolution as res, enchere as en where en.auteur={$_SESSION['myEkypId']} and en.vente_id=ve.id and (ve.resolue=1) and res.vente_id=en.vente_id and ve.joueur_id=jo.id and res.gagnant_id=ek.id order by ve.date_finencheres desc, ve.date_soumission desc limit 10"); 
		
		echo "<table class='tableau_liste' cellpading='0' cellspacing='0'>";
		echo "<tr><th>Date</th><th>Joueur</th><th>Enchere</th><th></th><th>Gagnée par</th><th>Montant</th><th>Diff</th><th></th></tr>";
		if ($listEnchQuery != NULL) {
			$i=0;
			foreach($listEnchQuery as $myEnch) {
				$classNum = $i %2;
				$i++;
				$montantEnchere = round($myEnch['montant'],1);
				$montantGagnant = round($myEnch['montant_gagnant'],1);
				$montantDeuxieme = round($myEnch['montant_deuxieme'],1);
				if ($_SESSION['myEkypId'] == $myEnch['idEkyp']) {
					$diff = '<b>+'.($montantGagnant - $montantDeuxieme).'</b>';
				} else {
					$diff = $montantEnchere - $montantGagnant;
				}
				$excl = $myEnch['exclue'];
				$picto = 'images/accept.png';
				if ($excl) {
					$picto = 'images/cross.png';
					$diff = '';
				}
				echo "<tr class='ligne{$classNum}'><td>{$myEnch['dateFin']}</td><td>{$myEnch['prenom']} {$myEnch['nomJoueur']}</td><td>{$montantEnchere} Ka</td><td><img src='{$picto}'/></td>";
				if (intval($myEnch['reserve']) || intval($myEnch['annulee']) ) {
					echo "<td colspan='3'>Vente annulée</td>";
				} else {
					echo "<td>{$myEnch['nomEkyp']}</td><td>{$montantGagnant} Ka</td><td>{$diff}</td>";
				}
				echo "<td><a href=\"javascript:affichage_popup('detailVente.php?venteid={$myEnch['idVente']}','popup_details');\">détails...</a></td></tr>";
			}
		}
		
		echo "</table>";
		echo "» <a href='index.php?page=myEncheres'>Suivi des enchères</a>";
	?>
	</div>
	
	
	
	
	<div class="sous_titre">Paramètres de l'Ekyp</div>
	<div class='sectionPage'>
	<?php
		echo "<div class='cadreVente'><b>Logo actuel</b><br/><img src='{$getEkypQuery[0]['logo']}' alt='Pas de logo!'/><br/><br/>» <a href='index.php?page=editLogo'>Modifier</a></div>";
	?>
	</div>
	<div class='sectionPage'>
	<p>Texte de présentation</p>
	<?php
		echo "<form method='POST' action='process/saveMessage.php'><textarea name='presentation' cols='60' rows='3'>{$getEkypQuery[0]['presentation']}</textarea><br/>";
		echo "<br/>";
		echo "<input type='submit' value='Enregistrer'/></form>";
	?>
	</div>

<?php
if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>