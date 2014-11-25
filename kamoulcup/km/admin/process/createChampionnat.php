<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$inscrits = $_POST['franchises'];
	$nom = correctSlash($_POST['nom']);
	$jStart = correctSlash($_POST['jStart']);
	$jEnd = correctSlash($_POST['jEnd']);
	
// Championnat
	$createChampQ = "insert into km_championnat(chp_nom,chp_first_journee_numero,chp_last_journee_numero,chp_status) values ('{$nom}',{$jStart},{$jEnd}, 'CREATED')";
	$db->query($createChampQ);

// Inscriptions
	if ($inscrits != NULL) {
		foreach ($inscrits as $value) {
			$db->query("insert into km_inscription(ins_franchise_id,ins_championnat_id) select {$value},chp_id from km_championnat where chp_nom='{$nom}'");
		}
	}

	header('Location: ../index.php');
	exit();
?>