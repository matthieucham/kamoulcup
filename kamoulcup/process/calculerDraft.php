<?php
include('checkAccess.php');
include("../includes/db.php");
include('debugTrace.php');
include('api_draft.php');
include('api_poule.php');

checkAccess(4);

$poules = poule_listPoules();
if ($poules != NULL)
{
	foreach ($poules as $poule) {
		$trace = draft_compute($poule['id']);
		historiqueDebug($db,0,$trace);
	}
}

header('Location: ../index.php?page=bilanDraft');
exit();
?>