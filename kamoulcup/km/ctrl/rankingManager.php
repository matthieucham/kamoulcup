<?php
    include_once("../../includes/db.php");

    function getChampionnat($champId) {
        global $db;
        $rankQ = "select chp_nom, count(journee.id) as nbPlayed, chp_first_journee_numero, chp_last_journee_numero from km_championnat inner join journee where chp_id={$champId} and journee.numero in (chp_first_journee_numero,chp_last_journee_numero) and journee.date < now()";
        $chp = $db->getArray($rankQ);
        if ($chp == NULL) {
            return NULL;
        } else {
            return $chp[0];
        }
    }

    function getRanking($champId) {
        global $db;
        $rankQ = "select ekyp.id, ekyp.nom, sum(eks_score) as sumScore from ekyp inner join km_join_ekyp_championnat on jec_ekyp_id=ekyp.id left outer join km_ekyp_score on ekyp.id=eks_ekyp_id and eks_championnat_id={$champId} where jec_championnat_id={$champId} group by ekyp.id order by sumScore desc";
        return $db->getArray($rankQ);
    }

    function getRankingJournee($champId, $journeeId) {
        global $db;
        $rankQ = "select ekyp.id, ekyp.nom, eks_score from ekyp inner join km_join_ekyp_championnat on jec_ekyp_id=ekyp.id left outer join km_ekyp_score on ekyp.id=eks_ekyp_id and eks_championnat_id={$champId} where jec_championnat_id={$champId} and eks_journee_id={$journeeId} group by ekyp.id order by eks_score desc";
        return $db->getArray($rankQ);
    }

    function getRankingPlayersJournee($journeeId,$nbPlayers) {
        global $db;
        $rankQ = "select joueur.id, joueur.prenom, joueur.nom as nomJoueur, scl_salaire, jpe_score, ekyp.nom as nomEkyp from joueur inner join journee on journee.id={$journeeId} inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id and jjs_journee_id=journee.id inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id inner join km_joueur_perf on jpe_joueur_id=joueur.id inner join rencontre on jpe_match_id=rencontre.id and rencontre.journee_id=journee.id left outer join km_engagement on eng_joueur_id=jpe_joueur_id and eng_date_arrivee<=journee.date and (eng_date_depart > journee.date or eng_date_depart is null) left outer join ekyp on ekyp.id=eng_ekyp_id order by jpe_score desc limit {$nbPlayers}";
        return $db->getArray($rankQ);
    }

?>