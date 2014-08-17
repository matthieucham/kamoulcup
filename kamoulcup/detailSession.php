<?php
	include ('process/params/ekypParams.php');
	include ('process/formatStyle.php');
	
	if (! isset($_GET['sessionid'])) {
		echo '<p class=\"error\">Pas de sessionId !</p>';
		exit;
	}
	$getSessionQuery = $db->getArray("select se.numero, po.nom, date_format(se.date_pas,'%d/%m %H:%i'),date_format(se.date_encheres,'%d/%m %H:%i'),date_format(se.date_resolution,'%d/%m %H:%i'),(se.date_encheres < now()), (se.date_resolution > now()), (se.date_pas < now()),se.poule_id from session as se, poule as po where se.poule_id=po.id and se.id='{$_GET['sessionid']}' limit 1");
	$listSessionsVenteQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant, ek.nom as nomEkyp, jo.club_id, jo.id as joueurId, jo.id_lequipe,ek.id as ekypId from joueur as jo, vente as ve, ekyp as ek where ve.session_id='{$_GET['sessionid']}' and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_soumission asc");
	$paAllowed = false;
	$enchereAllowed = false;
	if (isset($_SESSION['myEkypId'])){
		if ($_SESSION['pouleId']==$getSessionQuery[0][8]) {
			$countEkypPAQuery = $db->getArray("select ve.id from vente as ve where ve.auteur_id='{$_SESSION['myEkypId']}' and ve.type='PA' and ve.session_id='{$_GET['sessionid']}'");
			$nbPA = 0;
			if ($countEkypPAQuery != NULL) {
				$nbPA = count($countEkypPAQuery[0][0]);
			}
			$nbJoueurs = 0;
			$countJoueursEkypQuery = $db->getArray("select count(joueur_id) from transfert where ekyp_id='{$_SESSION['myEkypId']}'");
			if ($countJoueursEkypQuery != NULL) {
				$nbJoueurs = $countJoueursEkypQuery[0][0];
			}
			
			// Test : a-t-on assez d'argent pour déposer une PA ?
			$getBudgetQuery = $db->getArray("select budget from ekyp where id='{$_SESSION['myEkypId']}' limit 1");
			$getPaQuery = $db->getArray("select sum(ve.montant) from vente as ve where ve.resolue=0 and ve.type='PA' and ve.auteur_id='{$_SESSION['myEkypId']}'");
			// Argent restant virtuel :
			$futurBudget = round(floatval($getBudgetQuery[0][0]),1) - round(floatval($getPaQuery[0][0]),1);
			
			$paAllowed = (($futurBudget > 0) && ($nbJoueurs < $EKY_nbmaxjoueurs) && ($nbPA < $EKY_nbPA) && ($getSessionQuery[0][5]==0) && ($getSessionQuery[0][6]==1) && ($getSessionQuery[0][7]==1));
			$enchereAllowed = ($getSessionQuery[0][5]==1) && ($getSessionQuery[0][6]==1) && ($getSessionQuery[0][7]==1);
			if ($enchereAllowed) {
				$encheresEnCoursQuery = $db->getArray("select id,montant,vente_id from enchere where auteur='{$_SESSION['myEkypId']}' and session_id='{$_GET['sessionid']}'");
			}
		}
	}
?>

<div class="sectionPage">
	<div class="titre_page">
		<?php echo "Session numéro {$getSessionQuery[0][0]}"; ?>
	</div>
	<p><?php echo "{$getSessionQuery[0][1]} - du {$getSessionQuery[0][2]} au {$getSessionQuery[0][4]}"; ?></p>
</div>
<div class="sectionPage">
	<div class="sous_titre">Joueurs à vendre</div>
	<div id="liste_ventes">
		<?php
			if ($listSessionsVenteQuery != NULL) {
				foreach($listSessionsVenteQuery as $vente) {
					echo "<div class=\"cadreVente\">";
					$position = traduire($vente[2]);
					$club = 'Sans club';
					if ($vente['club_id'] != NULL) {
						$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
						$club = $getClubQuery[0]['nom'];
					}
					echo "<b>{$vente['type']} de l'ekyp <a href=\"index.php?page=showEkyp&ekypid={$vente['ekypId']}\">{$vente['nomEkyp']}</a> sur <a href=\"index.php?page=detailJoueur&joueurid={$vente['joueurId']}\">{$vente['prenom']} {$vente['nomJoueur']}</a> ({$position}, {$club}): {$vente['montant']} Ka.</b>";
					if ($enchereAllowed && ($encheresEnCoursQuery != NULL)) { 
						foreach ($encheresEnCoursQuery as $enchere) {
							if ($vente['venteId'] == $enchere['vente_id']) {
								echo "  [{$enchere['montant']} Ka]";
							}
						}
					}
					echo '<br/><img src="'.getURLPhotoJoueur($vente['id_lequipe']).'" alt="photo '.$vente['nomJoueur'].'\"/>';
					echo "</div>";
				}
			} else {
				echo "<p>Pas de joueur en vente</p>";
			}
		?>
	</div>
	<?php
		if ($paAllowed) {
			echo "» <a href=\"index.php?page=addVente&sessionid={$_GET['sessionid']}\">Déposer une PA</a>";
		}
		if ($enchereAllowed) {
			echo "» <a href=\"index.php?page=editEncheresSessions&sessionid={$_GET['sessionid']}\">Enchérir</a>";
		}
	?>
</div>