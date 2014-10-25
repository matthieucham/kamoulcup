<?php
    include_once("../../includes/db.php");
    
    function getLastTransfer($playerId) {
        global $db;
        $trQ = "select eng_montant,eng_salaire,date_format(eng_date_arrivee,'%d/%m/%Y') as dateArrivee from km_engagement where eng_joueur_id={$playerId} and eng_date_depart is NULL limit 1";
        $tr = $db->getArray($trQ);
        return $tr[0];
    }
?>