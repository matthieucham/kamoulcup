<?php
    include_once("../../includes/db.php");
    
    function getFranchise($inscriptionId) {
        global $db;
        $ekypQ="select fra_nom,fin_solde,(select sum(eng_salaire) from km_engagement where eng_inscription_id={$inscriptionId} and eng_date_depart is null) as masseSalariale from km_franchise inner join km_inscription on ins_franchise_id=fra_id inner join km_finances on fin_inscription_id=ins_id where ins_id={$inscriptionId} order by fin_date desc, fin_id desc limit 1";
        $ekyp=$db->getArray($ekypQ);
        if ($ekyp == NULL) {
            return NULL;
        } else {
            return $ekyp[0];
        }
    }

    function getContratsFranchise($inscriptionId) {
        global $db;
        $sousContratQ="select joueur.id,joueur.prenom,joueur.nom,joueur.poste,eng_salaire,eng_montant,club.nom as nomClub, ltr_montant from joueur inner join km_engagement on id=eng_joueur_id inner join club on joueur.club_id=club.id left outer join km_liste_transferts on eng_id=ltr_engagement_id where eng_inscription_id={$inscriptionId} and eng_date_depart is null group by joueur.id order by field(poste,'G','D','M','A')";
        $sousContrat = $db->getArray($sousContratQ);
        return $sousContrat;
    }

    function getMasseSalarialeAtJournee($inscriptionId, $journeeId) {
        global $db;
        $sousContratQ="select sum(eng_salaire) from km_engagement inner join journee where eng_inscription_id={$inscriptionId} and journee.id={$journeeId} and eng_date_arrivee <= journee.date and (eng_date_depart is null or eng_date_depart > journee.date)";
        $sousContrat = $db->getArray($sousContratQ);
        return round(floatval($sousContrat[0][0]),1);
    }

    function getScoreFranchise($inscriptionId) {
        global $db;
        $scoreQ = "select sum(fsc_score) from km_franchise_score where fsc_inscription_id={$inscriptionId}";
        $sco = $db->getArray($scoreQ);
        if ($sco == NULL) {
            return 0.0;
        } else {
            return round(floatval($sco[0][0]),1);
        }
    }

function getScoresHistorique($inscriptionId) {
        global $db;
        $scoresQ = "select journee.numero,fsc_score,cro_id,cro_numero from km_franchise_score inner join km_championnat_round on cro_id=fsc_round_id inner join journee on journee.id=cro_journee_id where fsc_inscription_id={$inscriptionId} and cro_status='PROCESSED' order by cro_numero asc";
        return $db->getArray($scoresQ);
    }


    function getStatsFranchiseJoueur($inscriptionId,$joueurId) {
        global $db;
        $statsQ = "SELECT sum( jpe_score ) , count( cro_id ) FROM km_joueur_perf INNER JOIN km_engagement ON jpe_joueur_id = eng_joueur_id INNER JOIN km_selection_round ON sro_engagement_id = eng_id inner join km_championnat_round on sro_round_id=cro_id inner join km_inscription on ins_id={$inscriptionId} INNER JOIN rencontre ON jpe_match_id = rencontre.id INNER JOIN journee ON journee.id = rencontre.journee_id and cro_journee_id=rencontre.journee_id WHERE sro_selected=1 AND eng_inscription_id ={$inscriptionId} and eng_joueur_id={$joueurId} and journee.date>=eng_date_arrivee and (journee.date<eng_date_depart or eng_date_depart IS NULL) and cro_status='PROCESSED'";
        $stats = $db->getArray($statsQ);
        return $stats[0];
    }
?>