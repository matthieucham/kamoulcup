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

    function getRankingPlayersJournee($journeeId,$nbPlayers) {
        global $db;
        $rankQ = "select joueur.id, joueur.prenom, joueur.nom as nomJoueur, scl_salaire, jpe_score, ekyp.nom as nomEkyp from joueur inner join journee on journee.id={$journeeId} inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id and jjs_journee_id=journee.id inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id inner join km_joueur_perf on jpe_joueur_id=joueur.id inner join rencontre on jpe_match_id=rencontre.id and rencontre.journee_id=journee.id left outer join km_engagement on eng_joueur_id=jpe_joueur_id and eng_date_arrivee<=journee.date and (eng_date_depart > journee.date or eng_date_depart is null) left outer join ekyp on ekyp.id=eng_ekyp_id order by jpe_score desc limit {$nbPlayers}";
        return $db->getArray($rankQ);
    }

    function getScoresFranchise($franchiseId) {
        global $db;
        $scoresQ = "select journee.id,journee.numero,eks_score from km_ekyp_score inner join journee on journee.id=eks_journee_id where eks_ekyp_id={$franchiseId} order by journee.numero asc";
        return $db->getArray($scoresQ);
    }
?>