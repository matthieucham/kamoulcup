<?php
include_once("../../includes/db.php");

function getCurrentMercato() {
    global $db;
    $merkatoQ="select mer_id,date_format(mer_date_ouverture,'%d/%m/%Y %H:%i') as dateOuverture,date_format(mer_date_ouverture,'%d/%m/%Y %H:%i') as dateFermeture from km_mercato where mer_date_ouverture<now() and mer_date_fermeture>now() and mer_processed=0 limit 1";
    $merkato=$db->getArray($merkatoQ);
    if ($merkato != NULL) {
        return $merkato[0];
    } else {
        return NULL;
    }
}

function listProcessedMercatos() {
    global $db;
    $mecatQ = "select mer_id,date_format(mer_date_ouverture,'%d/%m/%Y %H:%i') as dateFermeture from km_mercato where mer_processed=1 order by mer_date_fermeture desc";
    $mercatos = $db->getArray($mecatQ);
    return $mercatos;
}
?>