<?php
    @include_once("../../includes/db.php");

    function getChampionnat($champId) {
        global $db;
        $rankQ = "select chp_nom, count(cro_id) as nbPlayed, chp_first_journee_numero, chp_last_journee_numero, chp_status from km_championnat inner join km_championnat_round on cro_championnat_id=chp_id where chp_id={$champId} and cro_status='PROCESSED'";
        $chp = $db->getArray($rankQ);
        if ($chp == NULL) {
            return NULL;
        } else {
            return $chp[0];
        }
    }

    function getRanking($champId) {
        global $db;
        $rankQ = "select fra_id, fra_nom, sum(fsc_score) as sumScore from km_franchise inner join km_inscription on ins_franchise_id=fra_id left outer join km_franchise_score on ins_id=fsc_inscription_id left outer join km_championnat_round on cro_championnat_id=ins_championnat_id and cro_id=fsc_round_id and cro_status='PROCESSED' where ins_championnat_id={$champId} group by fra_id order by sumScore desc";
        return $db->getArray($rankQ);
    }

    function getRankingJournee($champId, $roundId) {
        global $db;
        $rankQ = "select fra_id, fra_nom, fsc_score from km_franchise inner join km_inscription on ins_franchise_id=fra_id left outer join km_franchise_score on ins_id=fsc_inscription_id and ins_championnat_id={$champId} where fsc_round_id={$roundId} group by fra_id order by fsc_score desc";
        return $db->getArray($rankQ);
    }

    function getRankingPlayersJournee($roundId,$nbPlayers) {
        global $db;
        $rankQ = "select joueur.id, joueur.prenom, joueur.nom as nomJoueur, scl_salaire, jpe_score, fra_nom as nomEkyp from joueur inner join journee inner join km_championnat_round on cro_journee_id=journee.id inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id and jjs_journee_id=journee.id inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id inner join km_joueur_perf on jpe_joueur_id=joueur.id inner join rencontre on jpe_match_id=rencontre.id and rencontre.journee_id=journee.id left outer join (km_engagement,km_inscription,km_franchise) on eng_joueur_id=jpe_joueur_id and eng_date_arrivee<=journee.date and (eng_date_depart > journee.date or eng_date_depart is null) and eng_inscription_id=ins_id and ins_championnat_id=cro_championnat_id and fra_id=ins_franchise_id where cro_id={$roundId} and cro_status in ('PLAYED','PROCESSED') order by jpe_score desc limit {$nbPlayers}";
        return $db->getArray($rankQ);
    }

?>