<?php
    include_once("../../includes/db.php");

    function getJoueurStats($id,$journeesIds) {
        global $db;
        $lastJ = $journeesIds[0];
        $journees = implode(",",$journeesIds);
        $statsDernierQ = "select jpe_score from km_joueur_perf inner join rencontre on rencontre.id=jpe_match_id where jpe_joueur_id={$id} and rencontre.journee_id={$lastJ}";
        $statsNQ = "select avg(jpe_score) from km_joueur_perf inner join rencontre on rencontre.id=jpe_match_id where jpe_joueur_id={$id} and  rencontre.journee_id in ({$journees})";
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

    function getJoueurCommonInfo($joueurId) {
        global $db;
        $joueurQ = "select joueur.id as idJoueur,joueur.nom as nomJoueur,prenom,poste,club.id as idClub,club.nom as nomClub,scl_salaire from joueur inner join club on joueur.club_id=club.id inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id inner join journee on jjs_journee_id=journee.id where joueur.id={$joueurId} order by journee.date desc limit 1";
        $joueur = $db->getArray($joueurQ);
        return $joueur[0];
    }

    function getJoueurChampionnatInfo($joueurId,$championnatId) {
        global $db;
        $joueurQ = "select fra_id,fra_nom,eng_salaire,ltr_montant from km_franchise inner join km_inscription on fra_id=ins_franchise_id inner join km_engagement on eng_inscription_id=ins_id left outer join km_liste_transferts on ltr_engagement_id=eng_id where eng_joueur_id={$joueurId} and eng_date_depart is null and ins_championnat_id={$championnatId}";
        $joueur = $db->getArray($joueurQ);
        return $joueur[0];
    }

    function getJoueurHistorique($joueurId,$championnatId) {
        global $db;
        $histoQ = "select jpe_score, rencontre.id as idRencontre, rencontre.club_dom_id, rencontre.club_ext_id, rencontre.buts_club_dom, rencontre.buts_club_ext, journee.numero, cro_numero, clDom.id as idClubDom, clDom.nom as nomClubDom, clExt.id as idClubExt, clExt.nom as nomClubExt, scl_salaire, fra_id,fra_nom from km_joueur_perf inner join rencontre on rencontre.id=jpe_match_id inner join club as clDom on rencontre.club_dom_id=clDom.id inner join club as clExt on rencontre.club_ext_id=clExt.id inner join journee on rencontre.journee_id=journee.id inner join km_join_joueur_salaire on jjs_journee_id=journee.id and jjs_joueur_id=jpe_joueur_id inner join km_const_salaire_classe on jjs_salaire_classe_id=scl_id inner join km_championnat_round on cro_journee_id=journee.id  left outer join (km_engagement,km_inscription,km_franchise) on eng_joueur_id=jpe_joueur_id and eng_date_arrivee<=journee.date and (eng_date_depart>journee.date or eng_date_depart is null) and eng_inscription_id=ins_id and cro_championnat_id=ins_championnat_id and fra_id=ins_franchise_id where jpe_joueur_id={$joueurId} and cro_championnat_id={$championnatId} order by journee.numero asc";
        return $db->getArray($histoQ);
    }

?>