<?php
    include_once("../../includes/db.php");

    function getActualCompo($franchiseId,$roundId) {
        global $db;
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, sro_substitute as sub,sro_selected,sro_substitute,sro_sub_time,rencontre.id,jpe_score,coalesce(minutes,0) as actualTime from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_selection_round on eng_id=sro_engagement_id inner join km_championnat_round on sro_round_id=cro_id inner join km_inscription on eng_inscription_id=ins_id left outer join (rencontre,prestation,km_joueur_perf) on rencontre.journee_id=cro_journee_id  and ( joueur.club_id in (rencontre.club_dom_id, rencontre.club_ext_id) ) and jpe_match_id=rencontre.id and jpe_joueur_id=joueur.id and prestation.match_id=rencontre.id and prestation.joueur_id=joueur.id where ins_franchise_id={$franchiseId} and cro_id={$roundId}";
        return $db->getArray($compoQ);
    }

    function getSelectedCompo($franchiseId,$roundId,$isFuture=true) {
        global $db;
        $isFutureCriteria='';
        if ($isFuture) {
            $isFutureCriteria=' and eng_date_depart IS NULL';
        }
        $compoQ="select joueur.id as idJoueur, joueur.nom as nomJoueur, joueur.prenom,joueur.poste, club.nom as nomClub, sro_substitute as sub, sro_sub_time from joueur inner join km_engagement on eng_joueur_id=joueur.id inner join club on club.id=joueur.club_id inner join km_selection_round on eng_id=sro_engagement_id inner join km_championnat_round on sro_round_id=cro_id inner join km_inscription on eng_inscription_id=ins_id where ins_franchise_id={$franchiseId} and cro_id={$roundId}{$isFutureCriteria}";
        return $db->getArray($compoQ);
    }

    function clearCompo($franchiseId,$roundId) {
        global $db;
        $cleanQ="delete from km_selection_round where sro_round_id={$roundId} and sro_engagement_id in (select eng_id from km_engagement inner join km_inscription on ins_id=eng_inscription_id inner join km_championnat_round on cro_championnat_id=ins_championnat_id where ins_franchise_id={$franchiseId} and cro_id={$roundId})";
        $db->query($cleanQ);
    }

    function saveCompo($franchiseId,$roundId,$playerIds,$sub,$subtime=0) {
        global $db;
        //$ids=implode(",",$playerIds);
        foreach($playerIds as $playerId) {
        $compoQ="insert into km_selection_round(sro_engagement_id,sro_round_id,sro_substitute,sro_sub_time) select eng_id,{$roundId},{$sub},{$subtime} from km_engagement inner join km_inscription on ins_id=eng_inscription_id inner join km_championnat_round on cro_championnat_id=ins_championnat_id where eng_date_depart is null and ins_franchise_id={$franchiseId} and eng_joueur_id={$playerId} on duplicate key update sro_substitute={$sub}, sro_sub_time={$subtime}";
        $db->query($compoQ);
        }
    }
?>