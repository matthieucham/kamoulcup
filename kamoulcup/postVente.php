<?php
	checkAccess(1);
	checkEkyp();
	include ('process/formatStyle.php');
?>
<div class="sectionPage">
	<div class="titre_page">Déposer une PA</div>
	<p><b>Vous êtes sur le point de poster la proposition d'achat suivante:</b></p>
	<form method="POST" action="process/saveVente.php">
	<?php
		$joueurId = $_POST['joueurId'];
		$userPouleId = intval($_SESSION['pouleId']);
		$getJoueurQuery = $db->getArray("select prenom, nom, poste, club_id, id_lequipe from joueur where id={$joueurId} limit 1");
		$getEkypQuery = $db->getArray("select nom from ekyp where id={$_SESSION['myEkypId']} limit 1");
		$delaiPeriode = $db->getArray("select delai_encheres from periode where date_debut < now() and date_fin > now() and poule_id={$userPouleId} limit 1");
		$delai = intval($delaiPeriode[0][0]);
		$prenom = $getJoueurQuery[0]['prenom'];
		$nom = $getJoueurQuery[0]['nom'];
		$montant = $_POST['montant'];
		$montantArrondi = round(floatval($montant),1);
		$club = 'Sans club';
		if ($getJoueurQuery[0]['club_id'] != NULL) {
			$getClubQuery = $db->getArray("select cl.nom from club as cl where cl.id={$getJoueurQuery[0]['club_id']} limit 1");
			$club = $getClubQuery[0]['nom'];
		}
		$debTime = time();
		$finTime = calculDateFinEnchere($debTime,$delai);
		$dateDebut = date('d/m H:i:s',$debTime);
		$dateFin = date('d/m H:i:s',$finTime);
		
		echo "<div class=\"cadreVente\">";
		$position = traduire($getJoueurQuery[0]['poste']);
		echo "<b>PA de l'ekyp <a href=\"index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}\">{$getEkypQuery[0]['nom']}</a> sur <a href=\"index.php?page=detailJoueur&joueurid={$joueurId}\">{$prenom} {$nom}</a> ({$position}, {$club}): {$montantArrondi} Ka.</b>";
		//echo '<br/><img src="'.getURLPhotoJoueur($getJoueurQuery[0]['id_lequipe']).'" alt="photo '.$nom.'"/>';
		echo "<br/>Enchères du <b>{$dateDebut}</b> au <b>{$dateFin}</b>";
		echo "</div>";
		echo "<br/><p><i>Les dates de début et fin d'enchère sont données à titre indicatif, seul l'horaire visible par tous sur la page du marché des joueurs fait foi.</i></p><br/>";
		echo "<input type=\"hidden\" name=\"joueurId\" value=\"{$joueurId}\"/>";
		echo "<input type=\"hidden\" name=\"montant\" value=\"{$montantArrondi}\"/>";
		echo "<input type=\"hidden\" name=\"typeVente\" value=\"PA\"/>";
		echo "<div class='hr_feinte10'></div>";
		echo "<input type='submit' value='Confirmer'/>";
	?>
	</form>
</div>