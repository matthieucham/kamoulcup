<?php
    include_once("../../includes/db.php");
    
    function getPalmares($franchiseId) {
        global $db;
        $palmaQ = "select pal_ranking,chp_nom,chp_id from km_palmares inner join km_championnat on chp_id=pal_championnat_id where pal_franchise_id={$franchiseId} and pal_ranking in (1,2,3) order by pal_ranking asc";
        $palma = $db->getArray($palmaQ);
        return $palma;
    }
?>