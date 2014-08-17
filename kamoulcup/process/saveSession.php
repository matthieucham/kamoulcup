<?php
include('checkAccess.php');
checkAccess(4);
include("../includes/db.php");
include('validateForm.php');

$poule = $_POST['poule'];

$numero = correctSlash($_POST['numero']);
valideInt($numero,'Numero','manageSessions');

$dateDebut = htmlspecialchars(correctSlash($_POST['dateDebut']), ENT_COMPAT, 'UTF-8');
valideString($dateDebut,'Date début','manageSessions');

$dateEnchere = htmlspecialchars(correctSlash($_POST['dateEnchere']), ENT_COMPAT, 'UTF-8');
valideString($dateEnchere,'Date enchères','manageSessions');

$dateResolution = htmlspecialchars(correctSlash($_POST['dateResolution']), ENT_COMPAT, 'UTF-8');
valideString($dateResolution,'Date résolution','manageSessions');

$saveSessionQuery = "insert into session(date_pas,date_encheres,date_resolution,poule_id,numero) values(str_to_date('{$dateDebut}','%Y-%m-%d %H:%i:%s'),str_to_date('{$dateEnchere}','%Y-%m-%d %H:%i:%s'),str_to_date('{$dateResolution}','%Y-%m-%d %H:%i:%s'),'{$poule}','{$numero}')";

$db->query($saveSessionQuery) or die('Error, insert query failed, see log');

header('Location: ../index.php?page=manageSessions');
exit();
?>