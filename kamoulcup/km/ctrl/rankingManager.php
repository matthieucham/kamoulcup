<?php
    include_once("../../includes/db.php");

    function getRanking() {
        global $db;
        $rankQ = "select ekyp.id, ekyp.nom, sum(eks_score) as sumScore from ekyp inner join km_ekyp_score on ekyp.id=eks_ekyp_id group by ekyp.id order by sumScore desc";
        return $db->getArray($rankQ);
    }

    function getRankingJournee($journeeId) {
        global $db;
        $rankQ = "select ekyp.id, ekyp.nom, eks_score from ekyp inner join km_ekyp_score on ekyp.id=eks_ekyp_id where eks_journee_id={$journeeId} group by ekyp.id order by eks_score desc";
        return $db->getArray($rankQ);
    }
?>