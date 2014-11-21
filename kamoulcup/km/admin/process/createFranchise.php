<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$nom = correctSlash($_POST['nomFranchise']);
	$userId = correctSlash($_POST['user']);

	$createQ = "insert into km_franchise(fra_nom) values ('{$nom}')";
	$db->query($createQ);
    $associateQ = "update utilisateur set franchise_id=(select fra_id from km_franchise where fra_nom='{$nom}') where id={$userId}";
	$db->query($associateQ);

	header('Location: ../index.php');
	exit();
?>