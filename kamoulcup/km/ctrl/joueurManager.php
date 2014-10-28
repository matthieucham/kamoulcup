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
        $joueurQ = "select joueur.id as idJoueur,joueur.nom as nomJoueur,prenom,poste,club.id as idClub,club.nom as nomClub,eng_salaire,eng_ekyp_id,eng_date_depart,ekyp.nom as nomEkyp,scl_salaire,ltr_montant from joueur inner join club on joueur.club_id=club.id inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id and jjs_journee_id={$journeeId} inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id left outer join km_engagement on eng_joueur_id=joueur.id left outer join ekyp on ekyp.id=eng_ekyp_id left outer join km_liste_transferts on eng_id=ltr_engagement_id where joueur.id={$joueurId} limit 1";
        $joueur = $db->getArray($joueurQ);
        return $joueur[0];
    }

    function getJoueurHistorique($joueurId) {
        global $db;
        $histoQ = "select jpe_score, rencontre.id as idRencontre, rencontre.club_dom_id, rencontre.club_ext_id, rencontre.buts_club_dom, rencontre.buts_club_ext, journee.numero, clDom.id as idClubDom, clDom.nom as nomClubDom, clExt.id as idClubExt, clExt.nom as nomClubExt, scl_salaire, ekyp.id as idEkyp,ekyp.nom as nomEkyp from km_joueur_perf inner join rencontre on rencontre.id=jpe_match_id inner join club as clDom on rencontre.club_dom_id=clDom.id inner join club as clExt on rencontre.club_ext_id=clExt.id inner join journee on rencontre.journee_id=journee.id inner join km_join_joueur_salaire on jjs_journee_id=journee.id and jjs_joueur_id=jpe_joueur_id inner join km_const_salaire_classe on jjs_salaire_classe_id=scl_id left outer join km_engagement on eng_joueur_id=jpe_joueur_id and eng_date_arrivee<=journee.date and (eng_date_depart>journee.date or eng_date_depart is null) left outer join ekyp on eng_ekyp_id=ekyp.id where jpe_joueur_id={$joueurId} order by journee.numero asc";
        return $db->getArray($histoQ);
    }

?>