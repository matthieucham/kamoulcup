<?php
include("../includes/db.php");
include('../process/validateForm.php');

	$passwd = correctSlash($_POST['mdp']);

	$saveUserQuery = "update utilisateur set password=MD5('{$passwd}'), droit={$_POST['droit']} where id={$_POST['userid']}";

	$db->query($saveUserQuery) or die('Error, insert query failed, see log');
	
	header('Location: index.php');
	exit();
?>