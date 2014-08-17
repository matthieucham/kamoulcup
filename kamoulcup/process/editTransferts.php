<?php
include('checkAccess.php');
checkAccess(5);
include("../includes/db.php");
include('api_score.php');

$nbAVerrouiller = count($_POST['verrou']);
$nbALiberer = count($_POST['libre']);
$ekypId = intval($_POST['ekypid']);
for ($i=0;$i<$nbAVerrouiller;$i++) {
	// Met à jour le flag du transfert
	$db->query("update transfert set definitif=1 where joueur_id='{$_POST['verrou'][$i]}' and ekyp_id={$ekypId} limit 1") or die("Update query failed");
	$db->query("insert into info(date,ekyp_concernee_id,joueur_concerne_id,type) values (now(),{$ekypId},{$_POST['verrou'][$i]},'SE')");
}
for ($i=0;$i<$nbALiberer;$i++) {
	$montantQuery = $db->getArray("select prix_achat from transfert where joueur_id='{$_POST['libre'][$i]}' and ekyp_id={$ekypId} limit 1");
	// Efface le transfert coché
	$db->query("delete from transfert where joueur_id='{$_POST['libre'][$i]}' and ekyp_id={$ekypId} limit 1") or die("Delete query failed");
	// Recrédite l'ékyp
	$budgetQuery = $db->getArray("select budget from ekyp where id={$ekypId} limit 1");
	$nouveauBudget = floatval($budgetQuery[0][0]) + floatval($montantQuery[0][0]);
	$db->query("update ekyp set budget={$nouveauBudget} where id={$ekypId} limit 1");
}
calculScoreEkyp2($db, $ekypId);
header('Location: ../index.php?page=manageEkyps&id='.$ekypId);
exit();
?>

