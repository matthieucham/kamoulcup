<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$inscrits = $_POST['ekyps'];
	$nom = correctSlash($_POST['nom']);
	$jStart = correctSlash($_POST['jStart']);
	$nbJ = correctSlash($_POST['nbJ']);
	
	$createChampQ = "insert into km_championnat(chp_nom,chp_first_journee_id,chp_nb_journees) values ('{$nom}',{$jStart},{$nbJ})";
	$db->query($createChampQ);
	$lastId = mysql_insert_id();
	if ($inscrits != NULL) {
		foreach ($inscrits as $value) {
			$db->query("insert into km_join_ekyp_championnat(jec_ekyp_id,jec_championnat_id) values ({$value},{$lastId}) on duplicate key update jec_championnat_id={$lastId}");
		}
	}

	header('Location: ../index.php');
	exit();
?>