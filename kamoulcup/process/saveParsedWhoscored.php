<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");
include('api_score.php');
include('validateForm.php');

$tabJoueurs = $_POST['joueurDb'];
$tabClubs = $_POST['clubJoueur'];
$tabNotes = $_POST['noteJoueur'];
$matchId = intval($_POST['matchid']);

//var_dump($tabJoueurs);
//var_dump($tabNotes);

foreach ($tabNotes as $id => $note) {
	$joueurAssocieId = $tabJoueurs[$id];
	$clubId = $tabClubs[$id];
	if($joueurAssocieId > 0) {
		$updJoueurQuery = "update joueur set id_ws={$id} where id={$joueurAssocieId} limit 1";
		$db->query($updJoueurQuery);
		$noteSauvee = round(floatval($note),1);
		if ($note > 0) {
		$updNoteQuery = "insert into prestation(joueur_id,match_id,note_ff,club_id,minutes) values ({$joueurAssocieId},{$matchId},{$noteSauvee},{$clubId},90 ) on duplicate key update joueur_id={$joueurAssocieId},match_id={$matchId},note_ff={$noteSauvee}";
		$db->query($updNoteQuery);
		}
	}
}
	echo "<script>window.location.replace('../index.php?page=enterNotes&matchId={$matchId}');</script>";
	exit();
?>