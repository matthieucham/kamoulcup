<?php

	function isJoueurLibre($joueurId) {
		global $db;
		$getTransfertQuery = $db->getArray("select count(*) from transfert where joueur_id={$joueurId}");
		return ($getTransfertQuery[0][0] == 0);
	}
	
?>