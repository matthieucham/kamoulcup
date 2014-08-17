<?php
function draft_getRank($ekypId)
{
	global $db;
	$query="select draft_order from ekyp where id={$ekypId} limit 1";
	$result = $db->getArray($query);
	return intval($result[0][0]);
}

function draft_listChoices($ekypId) {
	global $db;
	$query="select id,`order`,joueur_id,poule_id from choix_draft where ekyp_id={$ekypId} order by `order` asc";
	return $db->getArray($query);
}

function draft_saveChoice($id,$pouleId,$ekypId,$joueurId,$order) {
	global $db;
	$retVal;
	if (intval($id) > 0) {
		// UPDATE
		$retVal = $db->query("update choix_draft set poule_id={$pouleId},ekyp_id={$ekypId},joueur_id={$joueurId},`order`={$order} where id={$id}") ;
	} else {
		// INSERT
		$retVal = $db->query("insert into choix_draft(poule_id,ekyp_id,joueur_id,`order`) values ({$pouleId},{$ekypId},{$joueurId},{$order}) ") ;
	}
	return $retVal;
}

/**
 * Résolution de la draft.
 * @param $pouleId
 */
function draft_compute($pouleId) {
	global $db;
	// Dans l'ordre des ékyps...
	$ekypsQuery = "select id,nom from ekyp where poule_id={$pouleId} order by draft_order asc";
	$ekypsInOrder = $db->getArray($ekypsQuery);
	$trace='';
	foreach ($ekypsInOrder as $ekyp) {
		$trace .= 'Attribution des choix de draft à l\'ékyp'.$ekyp['nom'];
		$choices = draft_listChoices($ekyp['id']);
		if ($choices == NULL) {
			$trace .= ' PAS DE CHOIX ENREGISTRE !';
		} else {
			foreach ($choices as $choice) {
				$dispoQuery = "select count(*) from transfert where joueur_id={$choice['joueur_id']} and poule_id={$choice['poule_id']}";
				$dispo = $db->getArray($dispoQuery);
				if (intval($dispo[0][0]) > 0) {
					$trace .= ' Choix 1: '.$choice['joueur_id'].' indisponible. ';
				} else {
					// Joueur dispo !
					$insertQuery="insert into transfert(joueur_id,ekyp_id,transfert_date,poule_id,definitif,draft,choix_draft) values ({$choice['joueur_id']},{$ekyp['id']},now(),{$pouleId},1,1,{$choice['order']})";
					$db->query($insertQuery) or die("Insert transfert failed.");
					$trace .= " L'ékyp {$ekyp['nom']} a obtenu son choix {$choice['order']}: {$choice['joueur_id']}.";
					// Quitter la boucle
					break;
				}
			}
		}
	}
	$trace .= ' Fin draft. ';
	return $trace;
}
?>