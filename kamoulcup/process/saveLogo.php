<?php
	include('checkAccess.php');
	checkAccess(1);
	include("../includes/db.php");
	include('validateForm.php');

	$urlLogo = htmlspecialchars(correctSlash($_POST['logo']), ENT_COMPAT, 'UTF-8');
	if (strlen($urlLogo)==0) {
		$urlLogo = './img/defaultEkypLogo.png';
	}
	//$imgSizeArray = getimagesize($urlLogo);
	//if ( $imgSizeArray[0] != 250) {
	//	$err = 'L\'image doit mesurer 250px de large';
	//	header('Location: ../index.php?page=myEkyp&ErrorMsg='.$err);
	//	exit();
	//}
	
	$db->query("update ekyp set logo='{$urlLogo}' where id='{$_SESSION['myEkypId']}' limit 1");
	
	header('Location: ../index.php?page=myEkyp');
	exit();
?>