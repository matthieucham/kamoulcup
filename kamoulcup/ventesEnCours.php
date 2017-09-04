<?php
include ('process/params/ekypParams.php');
include ('process/formatStyle.php');
include ('process/api_marche.php');
include ('process/api_user.php');
$listPoulesQuery = $db->getArray("select id,nom from poule order by nom asc");
?>

<div class="sectionPage">
<div class="titre_page"><?php echo "Le marché des joueurs"; ?></div>
</div>

<?php
foreach ($listPoulesQuery as $poule) {
	$periodesEnCours = getOpenPeriode(intval($poule['id']),TRUE);
	if ($periodesEnCours != NULL) {
	foreach ($periodesEnCours as $periode) {
		if ($periode['draft']) {
		} else {
			// Les reventes à la banque sont masquées.
			$listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant, ek.nom as nomEkyp, jo.id as joueurId, jo.id_lequipe,ek.id as ekypId, jo.club_id, date_format(ve.date_soumission,'%d/%m %H:%i:%s') as debDate,date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as finDate from joueur as jo, vente as ve, ekyp as ek where ve.resolue=0 and ve.departage_attente=0 and ve.date_finencheres>now() and ve.joueur_id=jo.id and ve.auteur_id=ek.id and ve.poule_id={$poule['id']} and ve.type<>'RE' order by ve.date_soumission asc");
			$statsVentesQuery = $db->getArray("select sum(budget) from ekyp where poule_id={$poule['id']}");
			$sumBudget = number_format(floatval($statsVentesQuery[0][0]),2);
			$paAllowed = false;
			$enchereAllowed = false;
			if (dirigeEkypDeLaPoule($poule['id'])){
				$countEkypPAQuery = $db->getArray("select count(ve.id) from vente as ve where ve.auteur_id='{$_SESSION['myEkypId']}' and ve.type='PA' and ve.resolue=0");
				$nbPA = 0;
				if ($countEkypPAQuery != NULL) {
					$nbPA = $countEkypPAQuery[0][0];
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
	
				$paAllowed = (($futurBudget > 0) && ($nbJoueurs < $EKY_nbmaxjoueurs) && ($nbPA < $EKY_nbPA) && ($periode != NULL));
				$encheresEnCoursQuery = $db->getArray("select id,montant,vente_id from enchere where auteur='{$_SESSION['myEkypId']}'");
				$enchereAllowed = ($listVentesQuery != NULL) && (count($listVentesQuery) > 0);
			}
		}
	?>
<div class='sectionPage'>
<div class='sous_titre'><?php echo $poule['nom']; ?></div>
	<?php
		if ($periode != NULL && intval($periode['draft'])>0) {
			echo "<p>DRAFT EN COURS !</p>";
			if (dirigeEkypDeLaPoule($poule['id']))
			{
				echo "<p>Envoyez vos voeux avant le <b>{$periode['fin']}</b>.</p>";
				echo "» <a href=\"index.php?page=editDraft\">Enregistrer ou modifier ses voeux</a><br/>";
			}
		}
		else {
			if ($periode != NULL)
			{
				echo "<p>Mises aux enchères autorisées du <b>{$periode['debut']} au {$periode['fin']}</b>.</p>";
				echo "<p>Les enchères durent <b>{$periode['delai_encheres']} heures</b> à partir de la mise en vente.</p>";
				echo "<p>Il reste <b>{$sumBudget}</b> Ka à dépenser.";
			} else {
				echo "<p>Le marché est actuellement fermé.</p>";
			}
			if ($paAllowed) {
				echo "» <a href=\"index.php?page=addVente\">Déposer une PA</a><br/>";
			}
			if ($enchereAllowed) {
				echo "» <a href=\"index.php?page=editEncheres\">Enchérir</a><br/>";
			}
			include('./div/ventesEnCoursDiv.php');
			if ($paAllowed) {
				echo "» <a href=\"index.php?page=addVente\">Déposer une PA</a><br/>";
			}
			if ($enchereAllowed) {
				echo "» <a href=\"index.php?page=editEncheres\">Enchérir</a><br/>";
			}
		}
	}
	}
?>
</div>
<?php
$listEnAttenteQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant, ek.nom as nomEkyp, jo.id as joueurId, jo.id_lequipe,ek.id as ekypId, jo.club_id, date_format(ve.date_soumission,'%d/%m %H:%i:%s') as debDate,date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as finDate from joueur as jo, vente as ve, ekyp as ek where ve.resolue=0 and ve.date_finencheres < now() and ve.joueur_id=jo.id and ve.auteur_id=ek.id and ve.poule_id={$poule['id']} and ve.type<>'RE' order by ve.date_finencheres asc");
if ($listEnAttenteQuery != NULL)  {
	echo "<div class='sectionPage'>";
	echo "<div class='sous_titre'>Ventes en attente de résolution</div>";
	echo "<div id='liste_ventes'>";
	foreach($listEnAttenteQuery as $vente) {
		echo "<div class=\"cadreVente\">";
		$position = traduire($vente['poste']);
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
		//echo '<br/><img src="'.getURLPhotoJoueur($vente['id_lequipe']).'" alt="photo '.$vente['nomJoueur'].'\"/>';
		echo "<br/>Enchères fermées depuis le <b>{$vente['finDate']}</b>";
		echo "</div>";
	}
	echo "</div>";
	echo "</div>";
}
}
?>
