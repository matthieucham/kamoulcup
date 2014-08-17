<?php
	include('checkAccess.php');
	checkAccess(1);
	include("../includes/db.php");
	include('validateForm.php');

	$presentation = htmlspecialchars(correctSlash($_POST['presentation']), ENT_COMPAT, 'UTF-8');
	$db->query("update ekyp set presentation='{$presentation}' where id='{$_SESSION['myEkypId']}' limit 1");
	
	header('Location: ../index.php?page=myEkyp');
	exit();
?>