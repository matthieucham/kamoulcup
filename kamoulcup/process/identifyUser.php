<?php

//echo "<script>window.location.replace('../index.php?page=identification&ErrorMsg=NON');</script>";
//	exit();

include("../includes/db.php");
// Cette page acc�de � la session
session_start();
$utilisateur = $_POST['nom'];
$mdp = $_POST['password'];
if (!get_magic_quotes_gpc()) {
    $utilisateur = addslashes($_POST['nom']);
	$mdp = addslashes($_POST['password']);
}

$getUserQuery = "select ut.droit,ut.ekyp_id,ek.poule_id,ek.km from utilisateur as ut, ekyp as ek where ut.nom= '{$utilisateur}' and ut.password=MD5('{$mdp}') and ((ek.id = ut.ekyp_id) or(ut.ekyp_id is NULL))limit 1";
$storedUser = $db->getArray($getUserQuery);
if ($storedUser == NULL) {
	// Utilisateur inconnu
	$errorMsg='Mauvais identifiants. Contactez l administrateur';
	//header('Location: ../index.php?page=identification&errorMsg='.$errorMsg);
	echo "<script>window.location.replace('../index.php?page=identification&ErrorMsg={$errorMsg}');</script>";
	exit();
	}
else {
		// Enregistrer le nom d'utilisateur et ses droits dans la session
		$username=$utilisateur;
		$userrights=$storedUser[0]['droit'];
		
		$_SESSION['username'] = $username;
		$_SESSION['userrights'] = $userrights;
		// Enregistrement de l'ekyp
		if (isset($storedUser[0]['ekyp_id'])) {
			$km = $storedUser[0]['km'];
			$_SESSION['myEkypId'] = $storedUser[0]['ekyp_id'];
			$_SESSION['km'] = $km;
		}
		if (isset($storedUser[0]['poule_id'])) {
			$_SESSION['pouleId'] = $storedUser[0]['poule_id'];
		}
	} 

//header('Location: ../index.php');
echo "<script>window.location.replace('../index.php?page=myEkyp');</script>";
exit();

?>