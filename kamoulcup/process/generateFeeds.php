<?php
include('../includes/db.php');
include('api_feed.php');

  // Je récupère le dernier feed et je le fabrique
  // createResolutionEntry(363);
  
	$getResolutionsIds = $db->getArray("select id from resolution");
	if ($getResolutionsIds != NULL) {
		foreach($getResolutionsIds as $rid) {
			createResolutionEntry($rid[0]);
		}
	}
?>