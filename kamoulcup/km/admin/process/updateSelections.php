<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');

	$journeeId = correctSlash($_POST['journee']);
	
	// 	1) Récupérer la date de la journée choisie
	$selectDateQ = $db->getArray("select date from journee where id={$journeeId}");
	$jDate = $selectDateQ[0][0];
	
	// 2) Liste des joueurs qui ont participé aux matchs
	$joueursQ = "select eng_joueur_id,eng_id,rencontre.id from km_engagement,rencontre,prestation where prestation.joueur_id=eng_joueur_id and prestation.match_id=rencontre.id and rencontre.journee_id={$journeeId} and eng_date_arrivee <= '{$jDate}' and (eng_date_depart is null or eng_date_depart >= '{$jDate}') group by eng_joueur_id";
	
	//echo $joueursQ;
	$engagements = $db->getArray($joueursQ);
	
	if($engagements != NULL) {
		foreach($engagements as $eng) {
			$matchId = $eng['id'];
			$engagementId = $eng['eng_id'];
			$updateQ = "insert into km_selection_ekyp_match (sem_match_id,sem_engagement_id) values ({$matchId},{$engagementId}) on duplicate key update sem_match_id={$matchId}";
			$db->query($updateQ);
		}
	}
	
	header('Location: ../index.php');
	exit();
?>