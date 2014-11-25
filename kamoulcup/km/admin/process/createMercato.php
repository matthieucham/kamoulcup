<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
    $mercatoChamps = $_POST['championnats'];
	$mercatoFrom = correctSlash($_POST['mercatoFrom']);
	$mercatoTo = correctSlash($_POST['mercatoTo']);
	$mercatoTime = correctSlash($_POST['mercatoTime']);
	
foreach ($mercatoChamps as $chpId) {
	$createQ = "insert into km_mercato(mer_date_ouverture,mer_date_fermeture,mer_processed,mer_championnat_id) values(date_add('{$mercatoFrom}',interval {$mercatoTime} hour),date_add('{$mercatoTo}',interval {$mercatoTime} hour),0,{$chpId})";
	$db->query($createQ);
}
	header('Location: ../index.php');
	exit();
?>