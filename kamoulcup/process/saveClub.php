<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('validateForm.php');
	
	$clubName = htmlspecialchars(correctSlash($_POST['nom']), ENT_COMPAT, 'UTF-8');
	valideString($clubName,'Nom','manageClubs');
	$uuid = correctSlash($_POST['uuid']);

	if ($_POST['nouveau']) {
		$saveClubQuery = "insert into club(nom,uuid) values('{$clubName}','{$uuid}')";
	} else {
		$saveClubQuery = "update club set nom='{$clubName}', uuid='{$uuid}' where id='{$_POST['id']}'";
	}
	$db->query($saveClubQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=manageClubs');
	exit();
?>