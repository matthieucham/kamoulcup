<?php
include('checkAccess.php');
checkAccess(4);
include("../includes/db.php");
include('validateForm.php');

$nom = htmlspecialchars(correctSlash($_POST['nom']), ENT_COMPAT, 'UTF-8');
valideString($nom,'Nom','manageEkyps');

$poule = correctSlash($_POST['poule']);

$budget = correctSlash($_POST['budget']);
valideFloat($budget,'Budget','manageEkyps');

$newmanager = correctSlash($_POST['newmanager']);

$tactique = correctSlash($_POST['tactique']);

$dOrder = correctSlash($_POST['draftOrder']);
valideInt($dOrder,'Rang draft','manageEkyps');

if ($_POST['nouveau']) {
	$saveEkypQuery = "insert into ekyp(nom,poule_id,budget,tactique_id,draft_order) values('{$nom}','{$poule}','{$budget}','{$tactique}','{$dOrder}')";
	$db->query($saveEkypQuery) or die('Error, insert query failed, see log');
	$ekId = mysql_insert_id();
} else {
	$saveEkypQuery = "update ekyp set nom='{$nom}', poule_id='{$poule}', budget='{$budget}', tactique_id='{$tactique}', draft_order='{$dOrder}' where id='{$_POST['id']}'";
	$db->query($saveEkypQuery) or die('Error, insert query failed, see log');
	$moveTransfertsQuery = "update transfert set poule_id={$poule} where ekyp_id={$_POST['id']}";
	$db->query($moveTransfertsQuery) or die('Error, insert query failed, see log');
	$ekId = $_POST['id'];
}

if (isset($newmanager)) {
	$setManagerQuery = "update utilisateur set ekyp_id='{$ekId}' where id='{$newmanager}'";
	$db->query($setManagerQuery) or die ('Ajout du manager a �chou�');
}

header('Location: ../index.php?page=manageEkyps');
exit();
?>