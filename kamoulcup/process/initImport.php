<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");
include('params/statnutsParams.php');
include('params/notationParams.php');
include('api_import.php');

$token = getAccessToken();
//importRencontres($token, $SN_test_step);
$steps = listJournees($token, $SN_instance);
// Parcours des résultats pour récupérer les steps:
// - qui ont une updated_at posterieure à last_sync
// - en se basant sur le numero de journée
for($i=0; $i < count($steps->steps); $i++) {
	$current = $steps->steps[$i];
	$numero = (int) $current->name;
	$syncdate = $current->updated_at;
	$uuid_journee = $current->uuid;
	$ts = strtotime($syncdate);
	$dbDate = date('c', $ts);
	$getJourneeQ = "select id from journee where numero={$numero}";
	$getJournee = $db->getArray($getJourneeQ);
	if ($getJournee == NULL) {
		$newJourneeQ = "insert into journee(numero, uuid, date, sync_me) values ({$numero},'{$uuid_journee}', now(), 1)";
		$db->query($newJourneeQ);
	} else {
		$syncMeQ = "update journee set sync_me=1, uuid='{$uuid_journee}' where numero={$numero} and (last_sync<'{$dbDate}' or last_sync is null)";
		$db->query($syncMeQ);
	}
}

header('Location: ../index.php?page=import');
exit();

?>