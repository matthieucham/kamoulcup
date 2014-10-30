<?php
include_once("../../includes/db.php");

function getLastJournee() {
    global $db;
    $lastJQ = "select id,numero,date_format(date,'%d/%m/%Y') as dateJournee from journee where date < now() order by date desc limit 1";
    $lastJ = $db->getArray($lastJQ);
    $lastJournee = $lastJ[0];
    return $lastJournee;
}

function getJournee($id) {
    global $db;
    $lastJQ = "select id,numero,date_format(date,'%d/%m/%Y') as dateJournee from journee where id={$id} limit 1";
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

function getNextJournee() {
    global $db;
    $nextJQ = "select id, numero, date_format(date,'%d/%m/%Y') as dateJournee from journee where date >= now() order by date asc limit 1";
    $nextJ = $db->getArray($nextJQ);
    if ($nextJ == NULL) {
        return NULL;
    } else {
        return $nextJ[0];
    }
}
?>