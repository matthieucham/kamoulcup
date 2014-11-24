<?php
include_once("../../includes/db.php");

function getLastProcessedRound($chpId) {
    global $db;
    $lastRoundQ = "select cro_id,cro_numero,numero,date_format(date,'%d/%m/%Y') as dateJournee from km_championnat_round inner join journee on cro_journee_id=id where cro_championnat_id={$chpId} and date<now() and cro_status='PROCESSED' order by cro_numero desc limit 1";
    $lastRound = $db->getArray($lastRoundQ);
    if ($lastRound == NULL) {
        return NULL;
    } else {
        return $lastRound[0];
    }
}

function getRoundInfo($roundId) {
    global $db;
    $roundQ = "select cro_id,cro_numero,numero,date_format(date,'%d/%m/%Y') as dateJournee from km_championnat_round inner join journee on cro_journee_id=id where cro_id={$roundId} limit 1";
    $round = $db->getArray($roundQ);
    if ($round == NULL) {
        return NULL;
    } else {
        return $round[0];
    }
}

function getNextRoundToPlay($chpId) {
    global $db;
    $nextRoundQ = "select cro_id,cro_numero,numero,date_format(date,'%d/%m/%Y') as dateJournee from km_championnat_round inner join journee on cro_journee_id=id where cro_championnat_id={$chpId} and cro_status='CREATED' and date>now() order by cro_numero asc limit 1";
    $nextRound = $db->getArray($nextRoundQ);
    if ($nextRound == NULL) {
        return NULL;
    } else {
        return $nextRound[0];
    }
}

?>