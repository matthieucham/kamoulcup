<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('notation.php');

	$nbSupprBonus = count($_POST['cancelled']);
	for ($i=0;$i<$nbSupprBonus;$i++) {
		// D'abord les annulations	
		$db->query("delete from bonus_joueur where id='{$_POST['cancelled'][$i]}'") or die("Delete query failed");
	}
	calculScoreJoueur2($db,$_POST['joueurId']);
	header('Location: ../index.php?page=manageBonus');
	exit();
?>

