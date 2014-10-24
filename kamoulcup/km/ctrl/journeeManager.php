<?php
include_once("../../includes/db.php");

function getLastJournee() {
    global $db;
    $lastJQ = "select id,numero,date from journee where date < now() order by date desc limit 1";
    $lastJ = $db->getArray($lastJQ);
    $lastJournee = $lastJ[0];
    return $lastJournee;
}

function getLastNJournees($n) {
    global $db;
    $lastJQ = "select id from journee where date < now() order by date desc limit {$n}";
    $lastJ = $db->getArray($lastJQ);
    if ($lastJ != NULL) {
        $output = array();
        foreach ($lastJ as $j) {
            array_push($output,$j['id']);
        }
        return $output;
    } else {
        return NULL;
    }
}
?>