<?php
include("../../../includes/db.php");
include("../../ctrl/accessManager.php");
checkAdminAccess();

$chpId = correctSlash($_POST['championnat']);

// calculer les points marqués par chaque ekyp à chaque journée pour le championnat concerné.

    $franchiseScoreQ = "select eng_inscription_id,journee.id,sum(jpe_score) as ekScore,chp_id FROM km_joueur_perf inner join km_engagement on eng_joueur_id=jpe_joueur_id inner join km_selection_round on sro_engagement_id=eng_id inner join rencontre on jpe_match_id=rencontre.id inner join journee on rencontre.journee_id=journee.id inner join km_championnat on journee.numero in (chp_first_journee_numero,chp_last_journee_numero) inner join km_inscription on ins_id=eng_inscription_id where sej_journee_id=journee.id and sej_substitute=0 and journee.id={$journeeId} group by eng_ekyp_id";

?>