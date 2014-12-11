<?php

include("../../includes/db.php");
session_start();
$utilisateur = $_POST['login'];
$mdp = $_POST['pwd'];
if (!get_magic_quotes_gpc()) {
    $utilisateur = addslashes($_POST['login']);
	$mdp = addslashes($_POST['pwd']);
}

if ($utilisateur == 'guest') {
    $_SESSION['username'] = 'guest';
    $_SESSION['userrights'] = 0;
    $_SESSION['myChampionnatId'] = 6;
    header('Location: ../view/index.php?kmpage=fixtures');
    die();
}

$getUserQuery = "select ut.droit,fra_id,ins_id,ins_championnat_id from utilisateur as ut left outer join (km_franchise,km_inscription,km_championnat) on fra_id = ut.franchise_id and fra_id=ins_franchise_id and ins_championnat_id=chp_id where ut.nom= '{$utilisateur}' and ut.password=MD5('{$mdp}') and chp_status in ('STARTED','CREATED') limit 1";
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
	$_SESSION['myFranchiseId'] = $storedUser[0]['fra_id'];
    $_SESSION['myInscriptionId'] = $storedUser[0]['ins_id'];
    $_SESSION['myChampionnatId'] = $storedUser[0]['ins_championnat_id'];
        header('Location: ../view/index.php');
        die();
} 

?>