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

    function clearCompo($franchiseId,$journeeId) {
        global $db;
        $cleanQ="delete from km_selection_ekyp_journee where sej_journee_id={$journeeId} and sej_engagement_id in (select eng_id from km_engagement where eng_ekyp_id={$franchiseId})";
        $db->query($cleanQ);
    }

    function saveCompo($franchiseId,$journeeId,$playerIds,$sub) {
        global $db;
        $ids=implode(",",$playerIds);
        $compoQ="insert into km_selection_ekyp_journee(sej_engagement_id,sej_journee_id,sej_substitute) select eng_id,{$journeeId},{$sub} from km_engagement where eng_date_depart is null and eng_ekyp_id={$franchiseId} and eng_joueur_id in ({$ids}) on duplicate key update sej_substitute={$sub}";
        $db->query($compoQ);
    }
?>