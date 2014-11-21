<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$inscrits = $_POST['franchises'];
	$championnat = correctSlash($_POST['championnat']);
	
	if ($inscrits != NULL) {
		foreach ($inscrits as $value) {
			$db->query("insert into km_inscription(ins_franchise_id,ins_championnat_id) values ({$value},{$championnat}) on duplicate key update ins_championnat_id={$championnat}");
		}
	}

	header('Location: ../index.php');
	exit();
?>