<?php
include_once("../../includes/db.php");

function getLastJournee() {
    global $db;
    $lastJQ = "select id,numero,date from journee order by date desc limit 1";
    $lastJ = $db->getArray($lastJQ);
    $lastJournee = $lastJ[0];
    return $lastJournee;
}
?>