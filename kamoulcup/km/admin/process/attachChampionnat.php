<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$inscrits = $_POST['ekyps'];
	$championnat = correctSlash($_POST['championnat']);
	
	if ($inscrits != NULL) {
		foreach ($inscrits as $value) {
			$db->query("insert into km_join_ekyp_championnat(jec_ekyp_id,jec_championnat_id) values ({$value},{$championnat}) on duplicate key update jec_championnat_id={$championnat}");
		}
	}

	header('Location: ../index.php');
	exit();
?>