<?php

/**
 * Retourne les p�riodes ouvertes actuellement
 * @param unknown_type $withDraft
 */
function getOpenPeriode($poule,$withDraft) {
	global $db;
	if ($withDraft) {
		$periodeEnCours = $db->getArray("select date_format(date_debut,'%d/%m %H:%i') as debut, date_format(date_fin,'%d/%m %H:%i') as fin, delai_encheres,draft,(date_debut<now() and date_fin>now()) as paPossible from periode where date_debut < now() and date_add(date_fin, interval delai_encheres hour) > now() and poule_id={$poule}");
	} else {
		$periodeEnCours = $db->getArray("select date_format(date_debut,'%d/%m %H:%i') as debut, date_format(date_fin,'%d/%m %H:%i') as fin, delai_encheres,draft,(date_debut<now() and date_fin>now()) as paPossible from periode where date_debut < now() and date_add(date_fin, interval delai_encheres hour) > now() and poule_id={$poule} and draft=0");
	}
	return $periodeEnCours;
}

function marche_isDraftOpen($pouleId) {
	global $db;
	$query="select id from periode where draft=1 and date_debut < now() and date_fin > now() and poule_id={$pouleId} limit 1";
	$result = $db->getArray($query);
	if ($result != NULL && count($result)>0) {
		return true;
	} else {
		return false;
	}
}
?>