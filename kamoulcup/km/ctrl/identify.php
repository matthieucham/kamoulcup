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

$getUserQuery = "select ut.droit,fra_id,cur.ins_id as curInsId,cur.ins_championnat_id as curChpId,old.ins_id as oldInsId,old.ins_championnat_id as oldChpId from utilisateur as ut inner join km_franchise on fra_id = ut.franchise_id left outer join (km_inscription cur,km_championnat curChp) on  fra_id=cur.ins_franchise_id and cur.ins_championnat_id=curChp.chp_id and curChp.chp_status in ('STARTED','CREATED') left outer join (km_inscription old ,km_championnat oldChp) on  fra_id=old.ins_franchise_id and old.ins_championnat_id=oldChp.chp_id and oldChp.chp_status='FINISHED' where ut.nom='{$utilisateur}' and ut.password=MD5('{$mdp}') order by oldChp.chp_last_journee_numero desc limit 1";
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
    if ($storedUser[0]['curInsId'] != NULL) {
        $_SESSION['myInscriptionId'] = $storedUser[0]['curInsId'];
        $_SESSION['myChampionnatId'] = $storedUser[0]['curChpId'];
    } else if ($storedUser[0]['oldInsId'] != NULL) {
        $_SESSION['myInscriptionId'] = $storedUser[0]['oldInsId'];
        $_SESSION['myChampionnatId'] = $storedUser[0]['oldChpId'];
    }
    header('Location: ../view/index.php');
    die();
} 

?>