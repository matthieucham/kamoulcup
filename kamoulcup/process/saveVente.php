<?php
include('checkAccess.php');
checkAccess(1);
include('../includes/db.php');
include ('params/ekypParams.php');
include('validateForm.php');
include('computeDate.php');
$userPouleId = intval(($_SESSION['pouleId']));
$periodeEnCours = $db->getArray("select unix_timestamp(date_debut), unix_timestamp(date_fin), delai_encheres, coeff_bonus_achat as fin from periode where date_debut < now() and date_fin > now() and poule_id={$userPouleId} limit 1");
checkAccessDate($periodeEnCours[0][0],$periodeEnCours[0][1]);

$montantPost = htmlspecialchars(correctSlash($_POST['montant']), ENT_COMPAT, 'UTF-8');
valideFloat($montantPost,'montant','addVente');

$montant = round(floatval($montantPost),1);

$joueurId = correctSlash($_POST['joueurId']);
valideString($joueurId,'joueurId','addVente');
	
$typeVente = $_POST['typeVente'];
$joueurId = $_POST['joueurId'];
$ekypId = $_SESSION['myEkypId'];

$budgetQuery = $db->getArray("select budget from ekyp where id='{$ekypId}'");

if ($montant > $budgetQuery[0][0]) {
	$errorMessage = "Cette PA est d'un montant plus �lev� que votre budget restant.";
	header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
	exit();
}

if ($montant <= 0) {
	$errorMessage = ":roll: Milhouse :roll:";
	header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
	exit();
}

$joueurLibreQuery = $db->getArray("select tr.id from transfert as tr where (tr.joueur_id='{$joueurId}') and (tr.poule_id={$userPouleId}) and (tr.ekypId is not NULL)");
$paEnCoursQuery = $db->getArray("select ve.id from vente as ve where ve.joueurId='{$joueurId}' and ve.resolue=0 and ve.poule_id={$userPouleId} and ve.type='PA'");
if ((intval($joueurLibreQuery[0][0]) > 0) || (intval($paEnCoursQuery[0][0]) > 0)) {
	$errorMessage = "Le joueur demand� n'est pas libre";
	header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
	exit();
}

$countEkypPAQuery = $db->getArray("select ve.id from vente as ve where ve.auteur_id='{$ekypId}' and ve.type='PA' and ve.resolue=0");
$nbPA = 0;
if ($countEkypPAQuery != NULL) {
	$nbPA = intval($countEkypPAQuery[0][0]);
}
if ($nbPA > 0) {
	$errorMessage = "Cette �kyp a d�j� une PA en cours";
	header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
	exit();
}

if ($typeVente == 'PA') {
	$nbJoueurs = 0;
	$countJoueursEkypQuery = $db->getArray("select count(joueur_id) from transfert where ekyp_id='{$_SESSION['myEkypId']}'");
	if ($countJoueursEkypQuery != NULL) {
		$nbJoueurs = $countJoueursEkypQuery[0][0];
	}
	if ($nbJoueurs >= $EKY_nbmaxjoueurs) {
		$errorMessage = "Nombre maximum de joueurs dans l'ekyp atteint, impossible de d�poser une PA avant d'avoir revendu";
		header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
		exit();
	}
}
$checkInsertQuery = $db->getArray("select id from vente where resolue=0 and joueur_id='{$joueurId}' and type='{$typeVente}' and poule_id={$userPouleId}");
if ($checkInsertQuery != NULL) {
	$errorMessage = "Une PA sur ce joueur a d�j� �t� d�pos�e";
	header('Location: ../index.php?page=addVente&ErrorMsg='.$errorMessage);
	exit();
}


//TODO HEURE FIN ENCHRES
$debTime = time();
$finTime = calculDateFinEnchere($debTime,intval($periodeEnCours[0][2]));
$coeff = round(floatval($periodeEnCours[0][3]),3);
$insDeb = date("Y-m-d H:i:s",$debTime);
$insFin = date("Y-m-d H:i:s",$finTime);
$insertVenteQuery = $db->query("insert into vente(date_soumission,date_finencheres,type,joueur_id,auteur_id,montant,poule_id,resolue,coeff_bonus_achat) values ('{$insDeb}','{$insFin}','{$typeVente}','{$joueurId}','{$_SESSION['myEkypId']}',$montant,'{$_SESSION['pouleId']}',0,{$coeff})") or die("Insert query failed");
header('Location: ../index.php?page=ventesEnCours');
exit();
?>