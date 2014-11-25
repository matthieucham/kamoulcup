<?php
include_once("../../includes/db.php");

function getFinances($inscriptionId,$limit=10) {
    global $db;
    $financesQ="select date_format(fin_date,'%d/%m/%Y') as dateEvenement,fin_transaction,fin_solde,fin_event from km_finances where fin_inscription_id={$inscriptionId} order by fin_date desc,fin_id desc";
    $finances=$db->getArray($financesQ);
    return $finances;
}

?>