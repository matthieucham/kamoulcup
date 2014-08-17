<?php
include ('process/formatStyle.php');
include ('process/validateForm.php');

$sessionId;
if (! isset($_GET['sessionid'])) {
	$getLatestSessionQuery = $db->getArray("select id from session where (date_resolution < now()) order by numero desc limit 1");
	if ($getLatestSessionQuery == NULL) {
		echo 'Pas encore de session expirée!';
		exit;
	} else {
		$sessionId = $getLatestSessionQuery[0][0];
	}
} else {
	$sessionId = htmlspecialchars(correctSlash($_GET['sessionid']), ENT_COMPAT, 'UTF-8');
}

$getSessionQuery = $db->getArray("select se.numero, po.nom, date_format(se.date_pas,'%d/%m %H:%i'),date_format(se.date_resolution,'%d/%m %H:%i') from session as se, poule as po where se.poule_id=po.id and se.id='{$sessionId}' limit 1");
$listSessionsVenteQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as idVente, ve.type, ve.montant, ek.nom as nomEkyp, ek.id as idEkyp, jo.club_id, jo.id as idJoueur, jo.id_lequipe as eqJoueur from joueur as jo, vente as ve, ekyp as ek where ve.session_id='{$sessionId}' and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_soumission asc");
?>

<div class="sectionPage">
<div class="titre_page">Sessions terminées</div>
<p><?php echo "{$getSessionQuery[0][1]} - Session numéro {$getSessionQuery[0][0]} du {$getSessionQuery[0][2]} au {$getSessionQuery[0][3]}"; ?></p>
</div>
<div class="sectionPage">
<div class="sous_titre">Joueurs à vendre</div>
<div id="liste_ventes"><?php
if ($listSessionsVenteQuery != NULL) {
	foreach($listSessionsVenteQuery as $vente) {
		$club = 'Sans club';
		if ($vente['club_id'] != NULL) {
			$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
			$club = $getClubQuery[0]['nom'];
		}
		echo "<div class=\"cadreVente\">";
		$position = traduire($vente['poste']);
		$typeVente = traduire ($vente['type']);
		echo "{$typeVente} de l'ekyp <a href=\"index.php?page=showEkyp&ekypid={$vente['idEkyp']}\">{$vente['nomEkyp']}</a> sur <a href=\"index.php?page=detailJoueur&joueurid={$vente['idJoueur']}\">{$vente['prenom']} {$vente['nomJoueur']}</a> ({$position}, {$club}): {$vente['montant']} Ka.<br/>";
		echo '<img src="'.getURLPhotoJoueur($vente['eqJoueur']).'" alt="photo '.$vente['nomJoueur'].'\"/>';
		echo "</div>";
			
		$getResolutionQuery = $db->getArray("select res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, ek.nom,ek.id as ekId from resolution as res, ekyp as ek where res.vente_id='{$vente['idVente']}' and res.gagnant_id=ek.id limit 1");
		if ($getResolutionQuery != NULL) {
			echo "<div class=\"resolution\">";
			if ($getResolutionQuery[0]['annulee']) {
				echo "PA annulée car l'ékyp à son origine ne peut plus l'honorer";
			} else{
				if ($getResolutionQuery[0]['reserve']) {
					echo "MV annulée car le prix de réserve imposé par le vendeur n'a pas été atteint";
				} else {
					if ($vente['type'] == 'RE') {
						echo "Revendu à la banque pour {$getResolutionQuery[0]['montant_gagnant']} Ka";
					} else {
						echo "Rejoint <a href=\"index.php?page=showEkyp&ekypid={$getResolutionQuery[0]['ekId']}\">{$getResolutionQuery[0]['nom']}</a> pour {$getResolutionQuery[0]['montant_gagnant']} Ka";
						if ($getResolutionQuery[0]['montant_deuxieme'] > 0) {
							echo " (2e offre: {$getResolutionQuery[0]['montant_deuxieme']} Ka)";
						} else {
							echo " (Pas de 2e offre)";
						}
					}
				}
			}
			echo "</div>";
		} else {
			echo "<div class=\"resolution\">";
			echo "Non résolue";
			echo "</div>";
		}
	}
} else {
	echo "Aucun joueur à vendre au cours de cette session";
}
?></div>
</div>
<div class="sectionPage"><?php
$selectSessionQuery = $db->getArray("select id, numero from session where (date_resolution < now())order by numero desc");
echo "<form method='GET' action='index.php'>";
echo "Consulter la session numero ";
echo "<select size='1' name='sessionid'>";
foreach($selectSessionQuery as $session) {
	echo "<option value='{$session[0]}' ";
	if ($sessionId == $session[0]) {
		echo "selected";
	}
	echo ">{$session[1]}</option>";
}
echo "</select>";
echo " <input type='hidden' name='page' value='showClosedSession'/>";
echo "  <input type='submit' value='Consulter'/>";
echo "</form>";
?></div>
