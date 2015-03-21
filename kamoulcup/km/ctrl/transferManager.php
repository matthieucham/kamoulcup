<?php
    include_once("../../includes/db.php");
    
    function getLastTransfer($playerId,$championnatId) {
        global $db;
        $trQ = "select eng_montant,eng_salaire,date_format(eng_date_arrivee,'%d/%m/%Y') as dateArrivee from km_engagement inner join km_inscription on eng_inscription_id=ins_id where eng_joueur_id={$playerId} and ins_championnat_id={$championnatId} and eng_date_depart is NULL limit 1";
        $tr = $db->getArray($trQ);
        return $tr[0];
    }

    function listMercatoTransfers($mercatoId) {
        global $db;
        $trsQ = "select fra_nom as nomEkyp, jo.prenom, jo.nom as nomJoueur, premier.off_montant,coalesce(max(deuxieme.off_montant),0) as deuxiemeOffre from km_offre as premier inner join km_inscription on ins_id=premier.off_inscription_id and premier.off_winner=1 inner join km_franchise on ins_franchise_id=fra_id inner join joueur as jo on premier.off_joueur_id=jo.id left outer join km_offre as deuxieme on deuxieme.off_mercato_id=premier.off_mercato_id and deuxieme.off_joueur_id=premier.off_joueur_id and deuxieme.off_inscription_id=(select pomme.off_inscription_id from km_offre as pomme where pomme.off_winner=0 and pomme.off_joueur_id=premier.off_joueur_id and pomme.off_mercato_id={$mercatoId} order by pomme.off_montant desc limit 1) where premier.off_mercato_id={$mercatoId} group by premier.off_joueur_id";
        $trs = $db->getArray($trsQ);
        return $trs;
    }

    function listPlayerTransfers($playerId,$championnatId){
        global $db;
        $trQ = "select fra_id,fra_nom as nomEkyp, eng_montant, eng_salaire, date_format(eng_date_arrivee,'%d/%m/%Y') as dateArrivee, date_format(eng_date_depart,'%d/%m/%Y') as dateDepart,eng_date_arrivee,eng_date_depart from km_franchise inner join km_inscription on fra_id=ins_franchise_id and ins_championnat_id={$championnatId} inner join km_engagement on eng_inscription_id=ins_id where eng_joueur_id={$playerId} order by eng_date_arrivee asc";
        return $db->getArray($trQ);
    }

    function isListed($playerId) {
        global $db;
        $listQ = "select count(ltr_engagement_id) from km_liste_transferts inner join km_engagement on eng_id=ltr_engagement_id and eng_joueur_id={$playerId} where eng_date_depart is null";
        $listed = $db->getArray($listQ);
        return $listed[0][0] == 1;
    }

    function getLastReleases($championnatId, $limit) {
        global $db;
        $trQ = "select jo.id, jo.prenom, jo.nom, jo.poste, date_format(eng_date_depart,'%d/%m/%Y') as dateDepart, fra_nom from km_engagement inner join km_inscription on eng_inscription_id=ins_id inner join km_franchise on fra_id=ins_franchise_id inner join joueur as jo on jo.id=eng_joueur_id where ins_championnat_id={$championnatId} and eng_date_depart IS NOT NULL order by eng_date_depart desc limit {$limit}";
        $tr = $db->getArray($trQ);
        return $tr;
    }
?>