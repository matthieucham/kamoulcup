<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");

$joueurIds = $_POST['joueurid'];
$postes = $_POST['poste'];

for ($i=0; $i < count($joueurIds); $i++) {
	$currPoste = $postes[$i];
	$currJoueur = $joueurIds[$i];
	$updateQ = "update joueur set poste='{$currPoste}' where id={$currJoueur}";
	$db->query($updateQ);
}

header('Location: ../index.php?page=baboon');
exit();
?>