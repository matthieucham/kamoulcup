<?php
include_once("../../includes/db.php");

function getCurrentMercato() {
    global $db;
    $merkatoQ="select mer_id from km_mercato where mer_date_ouverture<now() and mer_date_fermeture>now() and mer_processed=0 limit 1";
    $merkato=$db->getArray($merkatoQ);
    if ($merkato != NULL) {
        return $merkato[0];
    } else {
        return NULL;
    }
}
?>