<?php

include("../../includes/db.php");
session_start();
$utilisateur = $_POST['login'];
$mdp = $_POST['pwd'];
if (!get_magic_quotes_gpc()) {
    $utilisateur = addslashes($_POST['login']);
	$mdp = addslashes($_POST['pwd']);
}

$getUserQuery = "select ut.droit,ut.ekyp_id,ek.poule_id,ek.km,jec_championnat_id from utilisateur as ut left outer join ekyp as ek on ek.id = ut.ekyp_id left outer join km_join_ekyp_championnat on jec_ekyp_id=ek.id where ut.nom= '{$utilisateur}' and ut.password=MD5('{$mdp}') limit 1";
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
    $_SESSION['champId'] = $storedUser[0]['jec_championnat_id'];
    if ($km) {
        header('Location: ../view/index.php');
        die();
    } else {
        header('Location: ../../index.php');
        die();
    }
} 

?>