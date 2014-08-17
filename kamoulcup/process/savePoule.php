<?php
	include('checkAccess.php');
	checkAccess(4);
	include("../includes/db.php");
	include('validateForm.php');

	$pouleName = htmlspecialchars(correctSlash($_POST['nom']), ENT_COMPAT, 'UTF-8');
	valideString($pouleName,'Nom','manageEkyps');

	if (isset($_POST['ouverte'])){
		$pouleOuverte = correctSlash($_POST['ouverte']);
		$poBool = ($pouleOuverte == 'on');
	} else {
		$poBool = 0;
	}

	if ($_POST['nouveau']) {
		$savePouleQuery = "insert into poule(nom,ouverte) values('{$pouleName}','{$poBool}')";
	} else {
		$savePouleQuery = "update poule set nom='{$pouleName}', ouverte='{$poBool}' where id='{$_POST['id']}'";
	}
	$db->query($savePouleQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=managePoules');
	exit();
?>