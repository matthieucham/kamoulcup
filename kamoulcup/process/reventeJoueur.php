<?php
	include ('params/ekypParams.php');
	
	// Cas de force majeure : le joueur n'évolue plus dans un club de L1
	function isReventeForceMajeure($db, $joueurId) {
		$getJoueurQuery = $db->getArray("select club_id from joueur where id='{$joueurId}' limit 1");
		return ($getJoueurQuery[0]['club_id'] == NULL);
	}
	
	function isReventeBaPossible($db,$ekypId,$joueurId) {
		global $EKY_nbReventesBA;
		$isDefinitifQuery = $db->getArray("select definitif from transfert where joueur_id={$joueurId} and ekyp_id={$ekypId} limit 1");
		if ($isDefinitifQuery[0][0]) {
			//echo "Définitif !";
			return false;
		}
		if (isReventeForceMajeure($db,$joueurId)) {
			//echo "Force majeure !";
			return true;
		}
		$isPossiblePeriode = $db->getArray("select reventes_autorisees from periode where date_debut < now() and date_fin > now() limit 1");
		if ($isPossiblePeriode == NULL) {
			//echo "Pas de p�riode !";
			return false;
		}
		if ($isPossiblePeriode[0][0] == 0) {
			//echo "Interdit dans la p�riode !";
			return false;
		}
		$getNbReventesQuery = $db->getArray("select revente_ba from ekyp where id='{$ekypId}' limit 1");
		if ($getNbReventesQuery[0][0] < $EKY_nbReventesBA) {
			return true;
		}
		//echo "Déjà trop de reventes !";
		return false;
	}
	
	function isMVPossible($db,$ekypId) {
		global $EKY_nbMV;
		$isPossiblePeriode = $db->getArray("select reventes_autorisees from periode where date_debut < now() and date_fin > now() limit 1");
		if ($isPossiblePeriode == NULL) {
			//echo "Pas de p�riode !";
			return false;
		}
		$getNbReventesQuery = $db->getArray("select id from vente where resolue=0 and type='MV' and auteur_id='{$ekypId}'");
		if ($getNbReventesQuery == NULL) {
			return true;
		} else {
			if (count($getNbReventesQuery) < $EKY_nbMV) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	function isVenteEnCours($db,$pouleId,$joueurId) {
		$venteEnCoursQuery = $db->getArray("select id from vente where poule_id='{$pouleId}' and joueur_id='{$joueurId}' and resolue=0 limit 1");
		return ($venteEnCoursQuery != NULL);
	}
	
	function isReventeEnCours($db,$pouleId,$joueurId) {
		$venteEnCoursQuery = $db->getArray("select id from vente where poule_id={$pouleId} and joueur_id={$joueurId} and resolue=0 and type='RE' limit 1");
		return ($venteEnCoursQuery != NULL);
	}
?>