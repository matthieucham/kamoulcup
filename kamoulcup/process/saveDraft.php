<?php
include('checkAccess.php');
checkAccess(1);
include("../includes/db.php");
include('validateForm.php');
include ('api_marche.php');
include ('api_draft.php');

if (marche_isDraftOpen($_SESSION['pouleId']))
{
	$pickedJoueurs = Array();
	$nbPicks = count($_POST['idPick']);
	$ekypId = $_SESSION['myEkypId'];
	$pouleId = $_SESSION['pouleId'];
	for ($i=0;$i<$nbPicks;$i++) {
		$pickId = $_POST['idPick'][$i];
		$joueurId = $_POST['joueurPick'][$i];
		$rank = $i+1;
		$result = true;
		if (isset($pickedJoueurs[$joueurId]) && $pickedJoueurs[$joueurId]=='check') {
			// Joueur déjà choisi
			$result=false;
		} else {
			$pickedJoueurs[$joueurId] = 'check';
			$result = draft_saveChoice($pickId, $pouleId, $ekypId, $joueurId, $rank);
		}
		if (! $result) {
			$err = addslashes("L'enregistrement a échoué, peut-être parce que vous avez sélectionné plusieurs fois le même joueur ?");
			echo "<script>window.location.replace('../index.php?page=editDraft&ErrorMsg={$err}');</script>";
			exit();
		}
	}
} else {
	$err = addslashes("Il est trop tard pour enregistrer ses choix de draft");
	echo "<script>window.location.replace('../index.php?page=index&ErrorMsg={$err}');</script>";
	exit();
}
header('Location: ../index.php?page=editDraft');
exit();
?>

