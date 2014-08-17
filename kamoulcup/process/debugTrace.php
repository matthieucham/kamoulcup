<?php

// Enregistre une trace dans la table historique_debug.
function historiqueDebug($db,$venteId,$texte) {
	$safeTexte = addslashes($texte);
	$db->query("insert into historique_debug(vente_id,date_enregistrement,texte_debug) values ('{$venteId}',now(),'{$safeTexte}')") or die ('Historique Debug insert query failed');
	return;
}
?>