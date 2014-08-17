<?php
	include('process/validateForm.php');
	include('process/formatStyle.php');
	include('process/params/ekypParams.php');
	include('process/params/notationParams.php');

	//global $SCO_journeePivot;
	
	if (! isset($_GET['ekypid'])) {
		echo '<p class=\"error\">Pas d\'ekypId !</p>';
		exit;
	}
	$ekypId = correctSlash($_GET['ekypid']);
		
	$getEkypQuery = $db->getArray("select po.nom as nomPoule, ek.nom, ek.logo, ek.budget, ek.score, ek.presentation, ek.revente_ba, ek.tactique_id,ek.score1,ek.score2 from ekyp as ek, poule as po where ek.id='{$ekypId}' and ek.poule_id=po.id limit 1");
	$listGardiensQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, jo.score,jo.id_lequipe from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='G' order by score desc");
	$listDefenseursQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, jo.score,jo.id_lequipe from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='D' order by score desc");
	$listMilieuxQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, jo.score,jo.id_lequipe from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='M' order by score desc");
	$listAttaquantsQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, jo.score,jo.id_lequipe from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='A' order by score desc");
	$listJoueursQuery = $db->getArray("select jo.id as idJoueur, jo.prenom, jo.nom as nomJoueur, jo.poste, jo.score,jo.id_lequipe, jo.club_id, tr.coeff_bonus_achat*jo.score as scoreBonif from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} order by field(jo.poste,'G','D','M','A')");
	$listManagersQuery = $db->getArray("select nom from utilisateur where ekyp_id='{$ekypId}'");
	$getTactiqueQuery = $db->getArray("select description,nb_g, nb_d, nb_m, nb_a from tactique where id='{$getEkypQuery[0]['tactique_id']}'");
	
	function displayJoueur($joueur) {
		$photo = getURLPhotoJoueur($joueur['id_lequipe']);
		echo "<img src=\"{$photo}\"/><br/>";
		$scoreFl = number_format(round($joueur['score'],2),2);
		echo "<a href='index.php?page=detailJoueur&joueurid={$joueur['id']}'>{$joueur['prenom']} {$joueur['nom']}</a>: {$scoreFl}";
	}
	
	function displayLigneJoueurs($listeJoueurs,$maxToDisplay){
		if ($listeJoueurs != NULL) {
			echo "<div class='effLigne'>";
			echo "<table class='effTable'><tr>";
			$i = 0;
			$nbjoueurs = count($listeJoueurs);
			while (($i < $maxToDisplay) && ($i < $nbjoueurs)) {
				echo "<td style='width:150px;'>";
				displayJoueur($listeJoueurs[$i]);
				$i++;
				echo "</td>";
			}
			echo "</tr></table>";
			echo "</div>";
		}
	}
?>

<div class="titre_page">
<?php
	echo $getEkypQuery[0]['nom'];
?>
</div>

<div class="colgauche_container">
	<div id='infosEkypLeft'>
		<?php
			if (isset ($getEkypQuery[0]['logo'])) {
				echo "<img src='{$getEkypQuery[0]['logo']}'/>";
			} else {
				echo "<img src='images/04.png'/>";
			}
		?>
	</div>
	<div id='infosEkypContent'>
		<?php
			echo "<div class='sous_titre'>{$getEkypQuery[0]['nom']}</div>";
			echo "<table class='tableau_horizon'>";
			echo "<tr><th>Dirigée par</th><td align='right'>";
			if ($listManagersQuery != NULL) {
				echo "<b>";
				foreach ($listManagersQuery as $manager) {
					echo ' '.$manager['nom'];
				}
				echo "</b>";
			} else {
				echo "personne";
			}
			echo "</td></tr>";
			echo "<tr><th>Argent restant</th><td align='right'>{$getEkypQuery[0]['budget']} Ka</td></tr>";
			echo "<tr><th>Tactique</th><td align='right'><b>{$getTactiqueQuery[0]['description']}</b></td></tr>";
			echo "<tr><th>Nombre de reventes à la BA</th><td align='right'>{$getEkypQuery[0]['revente_ba']}</td></tr>";
			$scoreFl = number_format(round($getEkypQuery[0]['score'],2),2);
			$scoreFl1 = number_format(round($getEkypQuery[0]['score1'],2),2);
			$scoreFl2 = number_format(round($getEkypQuery[0]['score2'],2),2);
			echo "<tr class='ligne_bilan'><th>Score</th><td align='right'>{$scoreFl}</td></tr>";
			echo "<tr class='ligne_bilan'><th>Score Apertura</th><td align='right'>{$scoreFl1}</td></tr>";
			echo "<tr class='ligne_bilan'><th>Score Clausura</th><td align='right'>{$scoreFl2}</td></tr>";
			echo "</table>";
			
			echo "<div class='sectionPage'>";
			echo "<div class='sous_titre'>Statistiques</div>";
			$getStatQuery = $db->getArray("select count(*) as nbGagne, max(montant_gagnant) as montantMax, min(montant_gagnant) as montantMin, avg(montant_gagnant) as montantMoy, avg(montant_gagnant - greatest(ve.montant,montant_deuxieme)) as surpay from resolution,vente as ve where ve.id=vente_id and gagnant_id={$ekypId}");

			if ($getStatQuery == NULL) {
				$nbGagne = 0;
				$montantMax = '-';
				$montantMin = '-';
				$montantMoy = '-';
				$surpay = '-';
			} else {
				$nbGagne = $getStatQuery[0][0];
				$montantMax = round($getStatQuery[0][1],1);
				$montantMin = round($getStatQuery[0][2],1);
				$montantMoy = round($getStatQuery[0][3],1);
				$surpay = round($getStatQuery[0][4],1);
			}
			
			$getActiviteQuery = $db->getArray("select count(*) as nbPA from vente as ve where ve.auteur_id = {$ekypId} and ve.type='PA'");
			$getActiviteAp = $db->getArray("select count(*) as nbPA from vente as ve where ve.auteur_id = {$ekypId} and ve.type='PA' and ve.date_soumission < (select jo.date from journee as jo where jo.numero={$SCO_journeePivot})");
			$getActiviteCl = $db->getArray("select count(*) as nbPA from vente as ve where ve.auteur_id = {$ekypId} and ve.type='PA' and ve.date_soumission > (select jo.date from journee as jo where jo.numero={$SCO_journeePivot})");
			$nbPasAp = 0;
			$nbPasCl = 0;
			if ($getActiviteQuery == NULL) {
				$nbPas = 0;
			} else {
				$nbPas = $getActiviteQuery[0]['nbPA'];
			}
			if ($getActiviteAp == NULL) {
				$nbPasAp = 0;
			} else {
				$nbPasAp = $getActiviteAp[0]['nbPA'];
			}
			if ($getActiviteCl == NULL) {
				$nbPasCl = 0;
			} else {
				$nbPasCl = $getActiviteCl[0]['nbPA'];
			}
			echo "<table class='tableau_horizon' style='width:300px;'>";
			echo "<tr><th>Enchères gagnées</th><td align='right'>{$nbGagne}</td></tr>";
			echo "<tr><th>Prix d'achat moyen</th><td align='right'>{$montantMoy} Ka</td></tr>";
			echo "<tr><th>Surpaiement moyen</th><td align='right'>{$surpay} Ka</td></tr>";
			echo "<tr><th>Achat max</th><td align='right'>{$montantMax} Ka</td></tr>";
			echo "<tr><th>Achat min</th><td align='right'>{$montantMin} Ka</td></tr>";
			if ($nbPasAp == 0) {
				echo "<tr class='ligne_bilan'><th>PAs postées en tout</th><td align='right'>{$nbPas}</td></tr>";
			} else {
				echo "<tr class='ligne_bilan'><th>PAs postées en Apertura</th><td align='right'>{$nbPasAp}</td></tr>";
				echo "<tr class='ligne_bilan'><th>PAs postées en Clausura</th><td align='right'>{$nbPasCl}</td></tr>";
			}
			echo "</table>";
			echo "<i>Attention : il y a	un nombre minimum de PA à poster tout au long du merkato pour ne pas être éliminé ! Se référer au règlement.</i>";
			echo "</div>";
			

		?>
	</div>
</div>

<div class='hr_feinte3'></div>
<?php
			echo "<div class='sectionPage'>";
			echo "<div class='sous_titre'>Présentation</div>";
			if ($getEkypQuery[0]['presentation'] != NULL) {
				echo $getEkypQuery[0]['presentation'];
			} else {
				echo "[Votre présentation ici]";
			}
			echo "</div>";
?>
<div class='sectionPage'>
<div class="sous_titre">Titulaires</div>
	<p><?php echo "{$getEkypQuery[0]['nom']} évolue en {$getTactiqueQuery[0]['description']}" ?></p><br/>
	
	<?php
	include('div/flexTitulairesDiv.php');
	?>
	
</div>


<div class='sectionPage'>
	<div class="sous_titre">Effectif complet</div>
	<div id="fullEffectif">
	<table class="tableau_liste">
	<?php
		if ($listJoueursQuery != NULL) {
			echo "<tr><th>Joueur</th><th>Poste</th><th>Club</th><th align='right'>Score</th><th align='right'>Bonification</th></tr>";
			$cptLigne = 0;
			foreach($listJoueursQuery as $joueur) {
				$club = 'Sans club';
				$clubId = 0;
				if ($joueur['club_id'] != NULL) {
					$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$joueur['club_id']}' limit 1");
					$club = $getClubQuery[0]['nom'];
					$clubId = $getClubQuery[0]['id'];
				}
				$poste = traduire($joueur['poste']);
				$scoreFl = number_format(round($joueur['score'],2),2);
				$bonification = round(floatval($joueur['scoreBonif'])-floatval($joueur['score']),2);
				if ($bonification == 0) {
					$bonifStr = '-';
				}
				if ($bonification > 0) {
					$bonifStr = '<b>+'.number_format($bonification,2).'</b>';
				}
				if ($bonification < 0) {
					$bonifStr = '<b>'.number_format($bonification,2).'</b>';
				}
				$classNum = $cptLigne % 2;
				$cptLigne++;
				echo "<tr class='ligne{$classNum}'><td><a href='index.php?page=detailJoueur&joueurid={$joueur['idJoueur']}'>{$joueur['prenom']} {$joueur['nomJoueur']}</a></td><td>{$poste}</td>";
				if ($clubId > 0) {
					echo "<td><a href='index.php?page=detailClub&clubid={$clubId}'>{$club}</a></td>";
				} else {
					echo "<td>Sans club</td>";
				}
				echo "<td>{$scoreFl}</td><td>{$bonifStr}</td></tr>";
			}
		}
	?>
	</table>
	</div>
</div>
<?php
	include('div/ekypProgressionDiv.php');
?>
