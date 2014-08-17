<?php
	include ('process/validateForm.php');
	checkAccess(1);
	checkEkyp();
	
	$dvId = $_POST['departageVenteId'];
	$getDvQuery = $db->getArray("select dv.montant_initial,dv.date_expiration,jo.id as joId,jo.nom,jo.prenom from departage_vente as dv,vente as ve, joueur as jo where (dv.id={$dvId}) and (dv.vente_id=ve.id) and (ve.joueur_id=jo.id) and (dv.ekyp_id='{$_SESSION['myEkypId']}') and ( dv.montant_nouveau IS NULL ) limit 1");
	//checkAccessDate(0,$getDvQuery[0]['date_expiration']);
	
?>


	<div class="titre_page">Surench'</div>
	<div class="sectionPage">
	<p><b>Vous êtes sur le point de poster la surenchère suivante:</b></p>
	<form method="POST" action="process/saveSurench.php">
	<?php
		$dvId = $_POST['departageVenteId'];
		$dvMontant = $_POST['departageVenteMontant'];
		$montantArrondi = round(floatval($dvMontant),1);
		$decline = isset($_POST['decline']);
		if ((!$decline) && ($getDvQuery[0]['montant_initial'] >= $montantArrondi)) {
			echo "<div class='error'>Le montant doit être supérieur à l'enchère initiale</div>";
		} else {
			echo "<a href='index.php?page=detailJoueur&joueurid={$getDvQuery[0]['joId']}'>{$getDvQuery[0]['prenom']} {$getDvQuery[0]['nom']}</a>: enchère actuelle: {$getDvQuery[0]['montant_initial']} Ka<br/>";
			if ($decline) {
				echo "<b>Pas de surenchère</b>";
			} else {
				echo "<b>Surenchère: {$montantArrondi} Ka</b>";
			}
			echo "<input type=\"hidden\" name=\"dvId\" value=\"{$dvId}\"/>";
			echo "<input type=\"hidden\" name=\"dvMontant\" value=\"{$montantArrondi}\"/>";
			echo "<input type=\"hidden\" name=\"decline\" value=\"{$decline}\"/>";
			echo "<br/><br/>";
			echo "<b>Attention :</b> La surenchère est définitive.<br/>";
			echo "<input type='submit' value='Confirmer'/>";
		}
	?>
	</form>
</div>