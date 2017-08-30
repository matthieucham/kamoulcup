<?php

/**
 * Retourner un tableau associatif club_id=>tableau de joueurs triés par poste
 */
function listDraftableJoueursSorted() {
	global $db;
	$listQuery = "select jo.id as joueurId,jo.prenom,jo.nom as nomJoueur,jo.poste,jo.club_id,cl.nom as nomClub FROM joueur as jo, club as cl WHERE jo.club_id IS NOT NULL and jo.club_id=cl.id and jo.id NOT IN (select joueur_id from vente) order by cl.nom asc, field(jo.poste,'G','D','M','A'), jo.nom asc";
	
	$allJoueurs = $db->getArray($listQuery);
	//	$output = array();
	//	$clubArray = array();
	//	$currentClubId=0;
	//	foreach ($allJoueurs as $currentJoueur) {
	//		if (intval($currentJoueur['club_id']) != $currentClubId) {
	//			if (count($clubArray) > 0 && $currentClubId > 0) {
	//				$output[$currentClubId] = $clubArray;
	//			}
	//			$clubArray = array();
	//			$currentClubId = intval($currentJoueur['club_id']);
	//		}
	//		$clubArray[]=$currentJoueur;
	//	}
	//	return $output;
	return $allJoueurs;
}

function joueur_getJoueurWithClub($joueurId) {
	global $db;
	$query = "select jo.id as idJoueur,jo.prenom,jo.nom as nomJoueur,jo.poste,jo.id_lequipe,jo.score,cl.nom as nomClub from joueur as jo, club as cl where jo.club_id=cl.id and jo.id={$joueurId} limit 1";
	$result = $db->getArray($query);
	return $result[0] ;
}
?>