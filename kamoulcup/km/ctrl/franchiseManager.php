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
        $sousContratQ="select joueur.id,joueur.prenom,joueur.nom,joueur.poste,eng_salaire,club.nom as nomClub from joueur inner join km_engagement on id=eng_joueur_id inner join club on joueur.club_id=club.id where eng_ekyp_id={$id} and eng_date_depart is null order by field(poste,'G','D','M','A')";
        $sousContrat = $db->getArray($sousContratQ);
        return $sousContrat;
    }

    function getScoreFranchise($id) {
        global $db;
        $scoreQ = "select sum(eks_score) from km_ekyp_score where eks_ekyp_id={$id}";
        $sco = $db->getArray($scoreQ);
        if ($sco == NULL) {
            return 0.0;
        } else {
            return round(floatval($sco[0][0]),1);
        }
    }
?>