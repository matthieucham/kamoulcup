<?php
    include_once("../../includes/db.php");

    function getCompo($franchiseId,$journeeId) {
        global $db;
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, jpe_score, sej_substitute as sub from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_joueur_perf on jpe_joueur_id=joueur.id inner join km_selection_ekyp_journee on eng_id=sej_engagement_id inner join journee on journee.id=sej_journee_id inner join rencontre on rencontre.id=jpe_match_id and rencontre.journee_id=journee.id where eng_ekyp_id={$franchiseId} and journee.id={$journeeId}";
        return $db->getArray($compoQ);
    }

    function getCompoNoScore($franchiseId,$journeeId,$isFuture=true) {
        global $db;
        $isFutureCriteria='';
        if ($isFuture) {
            $isFutureCriteria=' and eng_date_depart IS NULL';
        }
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, sej_substitute as sub from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_selection_ekyp_journee on eng_id=sej_engagement_id inner join journee on journee.id=sej_journee_id where eng_ekyp_id={$franchiseId} and journee.id={$journeeId}{$isFutureCriteria}";
        return $db->getArray($compoQ);
    }
?>