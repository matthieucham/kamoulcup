<?php
	include('checkAccess.php');
	checkAccess(5);
	include("../includes/db.php");
	include('api_score.php');
	
	calculTousScores($db);
	//echo mysql_error();
	header('Location: ../index.php?page=baboon');
	exit();
?>