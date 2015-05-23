<?php
	include('checkAccess.php');
	checkAccess(2);
	include("../includes/db.php");
	include('api_score.php');
	
	calculTousScores($db);
	//echo mysql_error();
	header('Location: ../index.php?page=baboon');
	exit();
?>