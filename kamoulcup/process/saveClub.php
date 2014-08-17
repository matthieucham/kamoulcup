<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('validateForm.php');
	
	$clubName = htmlspecialchars(correctSlash($_POST['nom']), ENT_COMPAT, 'UTF-8');
	valideString($clubName,'Nom','manageClubs');
	$idLequipe = correctSlash($_POST['idLEquipe']);

	if ($_POST['nouveau']) {
		$saveClubQuery = "insert into club(nom,id_lequipe) values('{$clubName}','{$idLequipe}')";
	} else {
		$saveClubQuery = "update club set nom='{$clubName}', id_lequipe='{$idLequipe}' where id='{$_POST['id']}'";
	}
	$db->query($saveClubQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=manageClubs');
	exit();
?>