<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
	
	$champ = correctSlash($_POST['champ']);
	if ($champ != 'score' && $champ != 'score1' && $champ != 'score2') {
		exit();
	}
	
	// Principe : on itère sur chaque classe de salaire.
	updateRange($champ,10,'limit 0,5');
	updateRange($champ,9,'limit  5,5');
	updateRange($champ,8,'limit 10,10');
	updateRange($champ,7,'limit 20,10');
	updateRange($champ,6,'limit 30,20');
	updateRange($champ,5,'limit 50,20');
	updateRange($champ,4,'limit 70,20');
	updateRange($champ,3,'limit 90,30');
	updateRange($champ,2,'limit 120,30');
	updateRange($champ,1,'limit 150,9999999999999');

	header('Location: ../index.php');
	exit();
	
	function updateRange($champ, $classeId,$range) {
		global $db;
		$query = "insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select jo.id,{$classeId},0 from joueur jo order by {$champ} desc {$range}";
		$db->query($query);
	}
?>