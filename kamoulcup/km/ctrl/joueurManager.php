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

    function getJoueur($joueurId,$journeeId) {
        global $db;
        $joueurQ = "select joueur.id as idJoueur,joueur.nom as nomJoueur,prenom,poste,club.id as idClub,club.nom as nomClub,eng_salaire,eng_ekyp_id,ekyp.nom as nomEkyp,scl_salaire from joueur inner join club on joueur.club_id=club.id inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id and jjs_journee_id={$journeeId} inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id left outer join km_engagement on eng_joueur_id=joueur.id left outer join ekyp on ekyp.id=eng_ekyp_id where eng_date_depart is NULL and joueur.id={$joueurId} limit 1";
        $joueur = $db->getArray($joueurQ);
        return $joueur[0];
    }

?>