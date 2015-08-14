<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");
include('params/statnutsParams.php');
#include('params/notationParams.php');
include('api_import.php');
include('notation.php');

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