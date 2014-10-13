<?php

include("../../includes/db.php");
session_start();
$utilisateur = $_POST['login'];
$mdp = $_POST['pwd'];
if (!get_magic_quotes_gpc()) {
    $utilisateur = addslashes($_POST['login']);
	$mdp = addslashes($_POST['pwd']);
}

$getUserQuery = "select ut.ekyp_id,ut.droit,ek.km from utilisateur as ut inner join ekyp as ek on ut.ekyp_id=ek.id where ut.nom= '{$utilisateur}' and ut.password=MD5('{$mdp}') limit 1";
$storedUser = $db->getArray($getUserQuery);
if ($storedUser == NULL) {
	header('Location: ../index.php');
    die();
} else {
	// Enregistrer le nom d'utilisateur et ses droits dans la session
	$username=$utilisateur;
	$userrights=$storedUser[0]['droit'];
	$_SESSION['username'] = $username;
	$_SESSION['userrights'] = $userrights;
    $km = $storedUser[0]['km'];
	$_SESSION['myEkypId'] = $storedUser[0]['ekyp_id'];
	$_SESSION['km'] = $km;
    if ($km) {
        header('Location: ../view/index.php');
        die();
    } else {
        header('Location: ../../index.php');
        die();
    }
} 

?>