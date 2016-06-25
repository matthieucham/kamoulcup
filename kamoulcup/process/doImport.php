<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");
include('params/statnutsParams.php');
#include('params/notationParams.php');
include('api_import.php');
include('notation.php');

$elims = $_POST['elim'];
$nb = count($elims);
for ($i=0;$i<$nb;$i++) {
	$uuid = $elims[$i];
	// update eliminatoire flag of current journee
	$q = "update journee set eliminatoire=1 where uuid='{$uuid}' limit 1";
	$db->query($q);
}

$uuids = $_POST['syncme'];
$nb = count($uuids);
$token = getAccessToken();
for ($i=0;$i<$nb;$i++) {
	$uuid = $uuids[$i];
	importRencontres($token, $uuid);
}
header('Location: ../index.php?page=postImport');
exit();
?>