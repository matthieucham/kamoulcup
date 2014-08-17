<?php
include("../includes/db.php");
include('checkAccess.php');
checkAccess(5);

$ekypId = intval($_POST[id]);
$getPouleQ = $db->getArray("select poule_id from ekyp where id={$ekypId} limit 1");
$pouleId = intval($getPouleQ[0][0]);
$_SESSION['myEkypId'] = $ekypId;
$_SESSION['pouleId'] = $pouleId;

echo "<script>window.location.replace('../index.php?page=myEkyp');</script>";
exit();

?>