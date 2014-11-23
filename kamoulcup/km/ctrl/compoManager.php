<?php
    include_once("../../includes/db.php");

    function getCompo($franchiseId,$roundId) {
        global $db;
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, sro_substitute as sub,rencontre.id,jpe_score from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_selection_round on eng_id=sro_engagement_id inner join km_championnat_round on sro_round_id=cro_id inner join km_inscription on eng_inscription_id=ins_id left outer join rencontre on rencontre.journee_id=cro_journee_id  and ( joueur.club_id in (rencontre.club_dom_id, rencontre.club_ext_id) ) left outer join km_joueur_perf on jpe_match_id=rencontre.id and jpe_joueur_id=joueur.id where ins_franchise_id={$franchiseId} and cro_id={$roundId}";
        return $db->getArray($compoQ);
    }

    function getCompoNoScore($franchiseId,$roundId,$isFuture=true) {
        global $db;
        $isFutureCriteria='';
        if ($isFuture) {
            $isFutureCriteria=' and eng_date_depart IS NULL';
        }
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, sro_substitute as sub from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_selection_round on eng_id=sro_engagement_id inner join km_championnat_round on sro_round_id=cro_id inner join km_inscription on eng_inscription_id=ins_id where ins_franchise_id={$franchiseId} and cro_id={$roundId}{$isFutureCriteria}";
        return $db->getArray($compoQ);
    }

    function clearCompo($franchiseId,$journeeId) {
        global $db;
        $cleanQ="delete from km_selection_ekyp_journee where sej_journee_id={$journeeId} and sej_engagement_id in (select eng_id from km_engagement where eng_ekyp_id={$franchiseId})";
        $db->query($cleanQ);
    }

    function saveCompo($franchiseId,$journeeId,$playerIds,$sub) {
        global $db;
        //$ids=implode(",",$playerIds);
        foreach($playerIds as $playerId) {
        $compoQ="insert into km_selection_ekyp_journee(sej_engagement_id,sej_journee_id,sej_substitute) select eng_id,{$journeeId},{$sub} from km_engagement where eng_date_depart is null and eng_ekyp_id={$franchiseId} and eng_joueur_id={$playerId} on duplicate key update sej_substitute={$sub}";
        $db->query($compoQ);
        }
    }
?>