<?php
	include('checkAccess.php');
	checkAccess(2);
	include("../includes/db.php");
	include('validateForm.php');
	
	$butsdom = correctSlash($_POST['butsdom']);
	valideInt($butsdom,'butsdom','manageMatchs');
	$butsext = correctSlash($_POST['butsext']);
	valideInt($butsext,'butsext','manageMatchs');
	$eliminationValue = 0;
	if (isset($_POST['elimination']))
	{
		$eliminationValue = 1;
	}

	if ($_POST['nouveau']) {
		$saveQuery = "insert into rencontre(club_dom_id,club_ext_id,buts_club_dom,buts_club_ext,journee_id,elimination) values('{$_POST['clubdom']}','{$_POST['clubext']}','{$butsdom}','{$butsext}','{$_POST['journee']}',{$eliminationValue})";
	} else {
		$saveQuery = "update rencontre set club_dom_id='{$_POST['clubdom']}', club_ext_id='{$_POST['clubext']}', buts_club_dom='{$butsdom}', buts_club_ext='{$butsext}', journee_id='{$_POST['journee']}', elimination={$eliminationValue} where id='{$_POST['id']}'";
	}
	$db->query($saveQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=manageMatchs');
	exit();
?>