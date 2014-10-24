<?php
    include_once("../../includes/db.php");
    
    function getFranchise($id) {
        global $db;
        $ekypQ="select nom,fin_solde,(select sum(eng_salaire) from km_engagement where eng_ekyp_id={$id} and eng_date_depart is null) as masseSalariale from ekyp inner join km_finances on fin_ekyp_id=id where id={$id} order by fin_date desc, fin_id desc limit 1";
        $ekyp=$db->getArray($ekypQ);
        if ($ekyp == NULL) {
            return NULL;
        } else {
            return $ekyp[0];
        }
    }

    function getContratsFranchise($id) {
        global $db;
        $sousContratQ="select id,prenom,nom,poste,eng_salaire from joueur inner join km_engagement on id=eng_joueur_id where eng_ekyp_id={$id} and eng_date_depart is null";
        $sousContrat = $db->getArray($sousContratQ);
        return $sousContrat;
    }
?>