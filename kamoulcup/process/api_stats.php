<?php
function stats_listJoueur($joueurId) {
	global $db;
	$query = "select jo.numero, sj.score,sj.score1,sj.score2 from stats_joueurs sj, journee jo where sj.journee_id=jo.id and sj.joueur_id={$joueurId} order by jo.numero asc";
	return $db->getArray($query);
}

function stats_getJoueur($joueurId,$journeeId) {
	global $db;
	$query = "select sj.score,sj.score1,sj.score2 from stats_joueurs sj where sj.journee_id={$journeeId} and sj.joueur_id={$joueurId} limit 1";
	return $db->getArray($query);
}

function stats_listEkyp($ekypId) {
	global $db;
	$query = "select jo.numero, se.score,se.score1,se.score2 from stats_ekyps se, journee jo where se.journee_id=jo.id and se.ekyp_id={$ekypId} order by jo.numero asc";
	return $db->getArray($query);
}

function stats_getEkyp($ekypId,$journeeId){
	global $db;
	$query = "select sj.score,sj.score1,sj.score2 from stats_ekyps sj where sj.journee_id={$journeeId} and sj.ekyp_id={$ekypId} limit 1";
	return $db->getArray($query);
}
?>