<?php
	include('checkAccess.php');
	checkAccess(1);
	include("../includes/db.php");
	include('validateForm.php');
	
	$getDvQuery = $db->getArray("select unix_timestamp(dv.date_expiration),dv.montant_initial,dv.vente_id from departage_vente as dv where dv.id='{$_POST['dvId']}' limit 1");
	checkAccessDate(0,$getDvQuery[0][0]);
	
	if ($_POST['decline'] == 1) {
		// Enchère déclinée
		// Montant retenu = montant initial
		$montantRetenu = floatval($getDvQuery[0][1]);
	} else {
		valideFloat(correctSlash($_POST['dvMontant']),'Montant surench','myEkyp');
		$mt = floatval(correctSlash($_POST['dvMontant']));
		if ($mt <= floatval($getDvQuery[0][1])) {
			$errorMessage = "Le montant de la surench doit être supérieur à celui de l'enchère initiale";
			header('Location: ../index.php?page=myEkyp&ErrorMsg='.$errorMessage);
			exit();
		}
		$montantRetenu = $mt;
	}
	// UPDATE
	$db->query("update departage_vente set montant_nouveau={$montantRetenu} where id='{$_POST['dvId']}' and ekyp_id='{$_SESSION['myEkypId']}'") or die("Update query failed");
	$db->query("update enchere set montant={$montantRetenu}, date_envoi=now() where vente_id={$getDvQuery[0][2]} and auteur={$_SESSION['myEkypId']}") or die("Update query failed");
	header('Location: ../index.php?page=myEkyp');
	exit();
?>

