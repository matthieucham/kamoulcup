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
        $sousContratQ="select joueur.id,joueur.prenom,joueur.nom,joueur.poste,eng_salaire,eng_montant,club.nom as nomClub, ltr_montant from joueur inner join km_engagement on id=eng_joueur_id inner join club on joueur.club_id=club.id left outer join km_liste_transferts on eng_id=ltr_engagement_id where eng_ekyp_id={$id} and eng_date_depart is null group by joueur.id order by field(poste,'G','D','M','A')";
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

    function getStatsFranchiseJoueur($franchiseId,$joueurId) {
        global $db;
        $statsQ = "SELECT sum( jpe_score ) , count( sej_journee_id )
FROM km_joueur_perf
INNER JOIN km_engagement ON jpe_joueur_id = eng_joueur_id
INNER JOIN km_selection_ekyp_journee ON sej_engagement_id = eng_id
INNER JOIN rencontre ON jpe_match_id = rencontre.id
INNER JOIN journee ON journee.id = rencontre.journee_id and sej_journee_id=rencontre.journee_id
WHERE sej_substitute =0
AND eng_ekyp_id ={$franchiseId} and eng_joueur_id={$joueurId} and journee.date>=eng_date_arrivee and (journee.date<eng_date_depart or eng_date_depart IS NULL)";
        $stats = $db->getArray($statsQ);
        return $stats[0];
    }
?>