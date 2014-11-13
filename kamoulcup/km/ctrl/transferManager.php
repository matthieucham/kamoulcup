<?php
    include_once("../../includes/db.php");
    
    function getLastTransfer($playerId) {
        global $db;
        $trQ = "select eng_montant,eng_salaire,date_format(eng_date_arrivee,'%d/%m/%Y') as dateArrivee from km_engagement where eng_joueur_id={$playerId} and eng_date_depart is NULL limit 1";
        $tr = $db->getArray($trQ);
        return $tr[0];
    }

    function listMercatoTransfers($mercatoId) {
        global $db;
        $trsQ = "select ek.nom as nomEkyp, jo.prenom, jo.nom as nomJoueur, off_montant from km_offre inner join ekyp as ek on off_ekyp_id=ek.id inner join joueur as jo on off_joueur_id=jo.id where off_winner=1 and off_mercato_id={$mercatoId}";
        $trs = $db->getArray($trsQ);
        return $trs;
    }

    function listPlayerTransfers($playerId){
        global $db;
        $trQ = "select ekyp.id as idEkyp,ekyp.nom as nomEkyp, eng_montant, eng_salaire, date_format(eng_date_arrivee,'%d/%m/%Y') as dateArrivee, date_format(eng_date_depart,'%d/%m/%Y') as dateDepart,eng_date_arrivee,eng_date_depart from ekyp inner join km_engagement on eng_ekyp_id=ekyp.id where eng_joueur_id={$playerId} order by eng_date_arrivee asc";
        return $db->getArray($trQ);
    }

    function isListed($playerId) {
        global $db;
        $listQ = "select count(ltr_engagement_id) from km_liste_transferts inner join km_engagement on eng_id=ltr_engagement_id and eng_joueur_id={$playerId} where eng_date_depart is null";
        $listed = $db->getArray($listQ);
        return $listed[0][0] == 1;
    }
?>