<?php
	include('checkAccess.php');
	checkAccess(1);
	include("../includes/db.php");
	include('validateForm.php');
	
	$mdpActuel = correctSlash($_POST['actuel']);
	$mdpNouveau1 = correctSlash($_POST['nouveau1']);
	$mdpNouveau2 = correctSlash($_POST['nouveau2']);
	
	valideString($mdpActuel,'mdpActuel','editPassword');
	valideString($mdpNouveau1,'mdpNouveau1','editPassword');
	valideString($mdpNouveau2,'mdpNouveau2','editPassword');
	
	if ($mdpNouveau1 != $mdpNouveau2) {
		$err= 'Incohérence entre le nouveau mot de passe et sa confirmation';
		//header('Location: ../index.php?page=editPassword&ErrorMsg='.$err);
		echo "<script>window.location.replace('../index.php?page=editPassword&ErrorMsg={$err}');</script>";
		exit();
	}
	
	$checkMdpQuery = $db->getArray("select id from utilisateur where nom='{$_SESSION['username']}' and password=md5('{$mdpActuel}') limit 1");
	if ($checkMdpQuery == NULL) {
		$err= 'Mot de passe actuel incorrect';
		//header('Location: ../index.php?page=editPassword&ErrorMsg='.$err);
		echo "<script>window.location.replace('../index.php?page=editPassword&ErrorMsg={$err}');</script>";
		exit();
	}
	$db->query("update utilisateur set password=md5('{$mdpNouveau1}') where nom='{$_SESSION['username']}' limit 1");
	
	echo "<script>window.location.replace('../index.php?page=baboon');</script>";
	exit();
?>

