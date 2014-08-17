<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('validateForm.php');
	include('api_score.php');
	
	$valeur = correctSlash($_POST['valeurBonus']);
	valideFloat($valeur,'valeur','manageBonus');
	$saveQuery = "insert into bonus_joueur(joueur_id,type,valeur) values({$_POST['joueurId']},'{$_POST['typeBonus']}',{$valeur})";
	$db->query($saveQuery) or die('Error, insert query failed, see log');
	calculScoreJoueur2($db,$_POST['joueurId']);
	header('Location: ../index.php?page=manageBonus');
	exit();
?>