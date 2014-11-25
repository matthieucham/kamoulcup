<?php
include("../../../includes/db.php");
include("../../ctrl/accessManager.php");
include('../../../process/validateForm.php');
checkAdminAccess();

$chpId = correctSlash($_POST['championnat']);

// calculer les points marqués par chaque ekyp à chaque journée pour le championnat concerné.
    $franchiseScoreQ = "select eng_inscription_id,cro_id,sum(jpe_score) as score FROM km_joueur_perf inner join km_engagement on eng_joueur_id=jpe_joueur_id inner join km_selection_round on sro_engagement_id=eng_id inner join rencontre on jpe_match_id=rencontre.id inner join km_championnat_round on rencontre.journee_id=cro_journee_id and cro_championnat_id={$chpId} inner join km_inscription on ins_id=eng_inscription_id where sro_round_id=cro_id and sro_substitute=0 and cro_status='PROCESSED' group by eng_inscription_id,cro_id";

$updateScoreQ = "insert into km_franchise_score(fsc_inscription_id,fsc_round_id,fsc_score) {$franchiseScoreQ} on duplicate key update fsc_score=values(fsc_score)";

$db->query($updateScoreQ);


	header('Location: ../index.php');
	exit();
?>