<?php
    include_once("../../includes/db.php");

    function getJoueurStats($id,$journeesIds) {
        global $db;
        $lastJ = $journeesIds[0];
        $journees = implode(",",$journeesIds);
        $statsDernierQ = "select jpe_score from km_joueur_perf where jpe_joueur_id={$id} and jpe_match_id in (select id from rencontre where journee_id={$lastJ})";
        $statsNQ = "select avg(jpe_score) from km_joueur_perf where jpe_joueur_id={$id} and jpe_match_id in (select id from rencontre where journee_id in ({$journees}))";
        $statsTotalQ = "select avg(jpe_score) from km_joueur_perf where jpe_joueur_id={$id}";
        
        $statsDernier = $db->getArray($statsDernierQ);
        $statsN = $db->getArray($statsNQ);
        $statsTotal = $db->getArray($statsTotalQ);
        
        $stats = array();
        $stats[0] = $statsDernier[0][0];
        $stats[1] = $statsN[0][0];
        $stats[2] = $statsTotal[0][0];
        
        return $stats;
    }

?>