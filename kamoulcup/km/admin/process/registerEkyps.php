<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$inscrits = $_POST['inscrits'];
	$db->query("update ekyp set km=0");
	if ($inscrits != NULL) {
		$updatesQ .= 'update ekyp set km=1 where id in ('.implode(',',$inscrits).')';
		$db->query($updatesQ);
	}

	header('Location: ../index.php');
	exit();
?>