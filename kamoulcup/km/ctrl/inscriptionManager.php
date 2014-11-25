<?php
    function getInscriptionFromRound($franchiseId,$roundId)
    {
        global $db;
        $inscriptionsQ = "select ins_id,ins_franchise_id from km_inscription inner join km_championnat_round on ins_championnat_id=cro_championnat_id where ins_franchise_id={$franchiseId} and cro_id={$roundId}";
        $inscr = $db->getArray($inscriptionsQ);
        if ($inscr == NULL) {
            return NULL;
        } else {
            return $inscr[0];
        }
    }

    function getInscriptionFromChampionnat($franchiseId,$championnatId)
    {
        global $db;
        $inscriptionsQ = "select ins_id,ins_franchise_id from km_inscription inner join km_championnat on ins_championnat_id=chp_id where ins_franchise_id={$franchiseId} and chp_id={$championnatId}";
        $inscr = $db->getArray($inscriptionsQ);
        if ($inscr == NULL) {
            return NULL;
        } else {
            return $inscr[0];
        }
    }

?>