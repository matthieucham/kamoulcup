<?php
include ('params/ekypParams.php');
include ('notation.php');
include ('api_prestation.php');
include ('api_transfert.php');
include ('api_journee.php');
include ('api_ekyp.php');
include ('api_stats.php');

function calculScoreEkyp2($db,$ekypId) {
	global $SCO_journeePivot;
	// Premi�re chose : calculer le score de tous les joueurs de l'effectif
	$listTransferts=transfert_listTransferts($ekypId);
	if ($listTransferts != NULL) {
		foreach ($listTransferts as $joueur) {
			calculScoreJoueur2($db,$joueur['joueur_id']);
		}
	}
	$getTactiqueQuery = ekyp_getTactique($ekypId);
	$EKY_nbg = $getTactiqueQuery[0][0];
	$EKY_nbd = $getTactiqueQuery[0][1];
	$EKY_nbm = $getTactiqueQuery[0][2];
	$EKY_nba = $getTactiqueQuery[0][3];

	$scoreFinalEkyp=0;
	$scoreFinalEkyp1=0;
	$scoreFinalEkyp2=0;
	$scoresG = Array();
	$scoresD = Array();
	$scoresM = Array();
	$scoresA = Array();
	//Conna�tre l'effectif � chaque journ�e
	$journees = journee_list();
	$lastJourneeNumero=0;
	if ($journees != NULL) {
		foreach($journees as $journee) {
			$scoreFinalEkyp=0;

			$effectif = transfert_listJoueursAtDate($ekypId, $journee['ts']);
			$scoresG = Array();
			$scoresD = Array();
			$scoresM = Array();
			$scoresA = Array();
			$scoresG1 = Array();
			$scoresD1 = Array();
			$scoresM1 = Array();
			$scoresA1 = Array();
			$scoresG2 = Array();
			$scoresD2 = Array();
			$scoresM2 = Array();
			$scoresA2 = Array();
			if ($effectif != NULL){
				foreach ($effectif as $joueur) {
					$coeff = floatval($joueur['coeff_bonus_achat']);
					$scoreJoueur = stats_getJoueur($joueur['id'], $journee['id']);
					if ($joueur['poste'] == 'G') {
						$scoresG[] = $scoreJoueur[0]['score']*$coeff;
						$scoresG1[] = $scoreJoueur[0]['score1']*$coeff;
						$scoresG2[] = $scoreJoueur[0]['score2']*$coeff;
					}
					if ($joueur['poste'] == 'D') {
						$scoresD[] = $scoreJoueur[0]['score']*$coeff;
						$scoresD1[] = $scoreJoueur[0]['score1']*$coeff;
						$scoresD2[] = $scoreJoueur[0]['score2']*$coeff;
					}
					if ($joueur['poste'] == 'M') {
						$scoresM[] = $scoreJoueur[0]['score']*$coeff;
						$scoresM1[] = $scoreJoueur[0]['score1']*$coeff;
						$scoresM2[] = $scoreJoueur[0]['score2']*$coeff;
					}
					if ($joueur['poste'] == 'A') {
						$scoresA[] = $scoreJoueur[0]['score']*$coeff;
						$scoresA1[] = $scoreJoueur[0]['score1']*$coeff;
						$scoresA2[] = $scoreJoueur[0]['score2']*$coeff;
					}
				}
				sort($scoresG);
				sort($scoresG1);
				sort($scoresG2);
				$scoresG = array_reverse($scoresG);
				$scoresG1 = array_reverse($scoresG1);
				$scoresG2 = array_reverse($scoresG2);
				sort($scoresD);
				sort($scoresD1);
				sort($scoresD2);
				$scoresD = array_reverse($scoresD);
				$scoresD1 = array_reverse($scoresD1);
				$scoresD2 = array_reverse($scoresD2);
				sort($scoresM);
				sort($scoresM1);
				sort($scoresM2);
				$scoresM = array_reverse($scoresM);
				$scoresM1 = array_reverse($scoresM1);
				$scoresM2 = array_reverse($scoresM2);
				sort($scoresA);
				sort($scoresA1);
				sort($scoresA2);
				$scoresA = array_reverse($scoresA);
				$scoresA1 = array_reverse($scoresA1);
				$scoresA2 = array_reverse($scoresA2);
			}
			for ($i=0; ($i<$EKY_nbg)&&($i<count($scoresG)); $i++ ) {
				$scoreFinalEkyp += $scoresG[$i];
			}
			for ($i=0; ($i<$EKY_nbd)&&($i<count($scoresD)); $i++ ) {
				$scoreFinalEkyp += $scoresD[$i];
			}
			for ($i=0; ($i<$EKY_nbm)&&($i<count($scoresM)); $i++ ) {
				$scoreFinalEkyp += $scoresM[$i];
			}
			for ($i=0; ($i<$EKY_nba)&&($i<count($scoresA)); $i++ ) {
				$scoreFinalEkyp += $scoresA[$i];
			}

			if ($journee['numero'] < $SCO_journeePivot) {
				$scoreFinalEkyp1=0;
				for ($i=0; ($i<$EKY_nbg)&&($i<count($scoresG1)); $i++ ) {
					$scoreFinalEkyp1 += $scoresG1[$i];
				}
				for ($i=0; ($i<$EKY_nbd)&&($i<count($scoresD1)); $i++ ) {
					$scoreFinalEkyp1 += $scoresD1[$i];
				}
				for ($i=0; ($i<$EKY_nbm)&&($i<count($scoresM1)); $i++ ) {
					$scoreFinalEkyp1 += $scoresM1[$i];
				}
				for ($i=0; ($i<$EKY_nba)&&($i<count($scoresA1)); $i++ ) {
					$scoreFinalEkyp1 += $scoresA1[$i];
				}
			} else {
				$scoreFinalEkyp2=0;
				for ($i=0; ($i<$EKY_nbg)&&($i<count($scoresG2)); $i++ ) {
					$scoreFinalEkyp2 += $scoresG2[$i];
				}
				for ($i=0; ($i<$EKY_nbd)&&($i<count($scoresD2)); $i++ ) {
					$scoreFinalEkyp2 += $scoresD2[$i];
				}
				for ($i=0; ($i<$EKY_nbm)&&($i<count($scoresM2)); $i++ ) {
					$scoreFinalEkyp2 += $scoresM2[$i];
				}
				for ($i=0; ($i<$EKY_nba)&&($i<count($scoresA2)); $i++ ) {
					$scoreFinalEkyp2 += $scoresA2[$i];
				}
			}
			storeStatEkyp($db,$scoreFinalEkyp,$scoreFinalEkyp1,$scoreFinalEkyp2,$ekypId,$journee['id']);
			$lastJourneeNumero=$journee['numero'];
		}
	}
	// Depuis la derni�re journ�e de r�sultats, l'effectif a pu �voluer, c'est pourquoi il faut en refaire une louche

	$scoreFinalEkyp=0;
	$scoreFinalEkyp1=0;
	$scoreFinalEkyp2=0;

	$effectif = transfert_listTransferts($ekypId);
	$scoresG = Array();
	$scoresD = Array();
	$scoresM = Array();
	$scoresA = Array();
	
	$scoresG1 = Array();
	$scoresD1 = Array();
	$scoresM1 = Array();
	$scoresA1 = Array();

	$scoresG2 = Array();
	$scoresD2 = Array();
	$scoresM2 = Array();
	$scoresA2 = Array();

	if ($effectif != NULL){
		foreach ($effectif as $joueur) {
			$coeff = floatval($joueur['coeff_bonus_achat']);
			if ($joueur['poste'] == 'G') {
				$scoresG[] = $joueur['score']*$coeff;
				$scoresG1[] = $joueur['score1']*$coeff;
				$scoresG2[] = $joueur['score2']*$coeff;
			}
			if ($joueur['poste'] == 'D') {
				$scoresD[] = $joueur['score']*$coeff;
				$scoresD1[] = $joueur['score1']*$coeff;
				$scoresD2[] = $joueur['score2']*$coeff;
			}
			if ($joueur['poste'] == 'M') {
				$scoresM[] = $joueur['score']*$coeff;
				$scoresM1[] = $joueur['score1']*$coeff;
				$scoresM2[] = $joueur['score2']*$coeff;
			}
			if ($joueur['poste'] == 'A') {
				$scoresA[] = $joueur['score']*$coeff;
				$scoresA1[] = $joueur['score1']*$coeff;
				$scoresA2[] = $joueur['score2']*$coeff;
			}
		}
		sort($scoresG);
		sort($scoresG1);
		sort($scoresG2);
		$scoresG = array_reverse($scoresG);
		$scoresG1 = array_reverse($scoresG1);
		$scoresG2 = array_reverse($scoresG2);
		sort($scoresD);
		sort($scoresD2);
		$scoresD = array_reverse($scoresD);
		$scoresD2 = array_reverse($scoresD2);
		sort($scoresD1);
		$scoresD1 = array_reverse($scoresD1);
		sort($scoresM);
		sort($scoresM2);
		$scoresM = array_reverse($scoresM);
		$scoresM2 = array_reverse($scoresM2);
		sort($scoresM1);
		$scoresM1 = array_reverse($scoresM1);
		sort($scoresA);
		sort($scoresA2);
		$scoresA = array_reverse($scoresA);
		$scoresA2 = array_reverse($scoresA2);
		sort($scoresA1);
		$scoresA1 = array_reverse($scoresA1);
	}
	for ($i=0; ($i<$EKY_nbg)&&($i<count($scoresG)); $i++ ) {
		$scoreFinalEkyp += $scoresG[$i];
		$scoreFinalEkyp1 += $scoresG1[$i];
		$scoreFinalEkyp2 += $scoresG2[$i]; 
	}
	for ($i=0; ($i<$EKY_nbd)&&($i<count($scoresD)); $i++ ) {
		$scoreFinalEkyp += $scoresD[$i];
		$scoreFinalEkyp1 += $scoresD1[$i];
		$scoreFinalEkyp2 += $scoresD2[$i];
	}
	for ($i=0; ($i<$EKY_nbm)&&($i<count($scoresM)); $i++ ) {
		$scoreFinalEkyp += $scoresM[$i];
		$scoreFinalEkyp1 += $scoresM1[$i];
		$scoreFinalEkyp2 += $scoresM2[$i];
	}
	for ($i=0; ($i<$EKY_nba)&&($i<count($scoresA)); $i++ ) {
		$scoreFinalEkyp += $scoresA[$i];
		$scoreFinalEkyp1 += $scoresA1[$i];
		$scoreFinalEkyp2 += $scoresA2[$i];
	}
//	$scoreFinalEkyp1=0;
//	if ($lastJourneeNumero < $SCO_journeePivot) {
//		$scoreFinalEkyp1 = $scoreFinalEkyp;
//		$scoreFinalEkyp2=0;
//	} else {
//		$journeeBeforePivot = journee_getLastJourneeBefore($SCO_journeePivot);
//		$registered = stats_getEkyp($ekypId, $journeeBeforePivot[0]['id']);
//		$scoreFinalEkyp1 = floatval($registered[0]['score1']);
//	}
	$isComplete = 0;
	if ((count($scoresG) >= $EKY_nbg) && (count($scoresD) >= $EKY_nbd) && (count($scoresM) >= $EKY_nbm) && (count($scoresA) >= $EKY_nba)) {
		$isComplete = 1;
	}
	//maj bdd
	$db->query("update ekyp set score={$scoreFinalEkyp},score1={$scoreFinalEkyp1},score2={$scoreFinalEkyp2}, complete={$isComplete} where id={$ekypId} limit 1");
}

function calculScoresToutesEkyps($db) {
	$listEkypQuery = $db->getArray("select id from ekyp");
	if ($listEkypQuery != NULL) {
		foreach($listEkypQuery as $ekypId) {
			calculScoreEkyp2($db,$ekypId['id']);
		}
	}
}

function calculScoresToutesPrestations($db) {
	// maj toutes prestations
	$db->query("update joueur set score=0,score1=0,score2=0");
	$listPrestationsQuery = $db->getArray("select id, joueur_id from prestation");
	if ($listPrestationsQuery != NULL) {
		foreach ($listPrestationsQuery as $prestation) {
			calculScorePrestation($db,$prestation['id']);
		}
	}
}

function calculScoresTousJoueurs($db) {
	$listJoueursQuery = $db->getArray("select id from joueur");
	if ($listJoueursQuery != NULL) {
		foreach ($listJoueursQuery as $joueur) {
			calculScoreJoueur2($db,$joueur['id']);
		}
	}
}

function calculTousScores($db) {
	calculScoresToutesPrestations($db);
	calculScoresToutesEkyps($db);
	// A commenter en cours de jeu, � d�commenter si on veut avoir tous les scores des joueurs
	// calculScoresTousJoueurs($db);
}

function updateToutesPrestations($db) {
	$matchs = $db->getArray("select id from rencontre");
	foreach ($matchs as $mId)
	{
		updatePrestationCollective($db,$mId[0]);
		calculLeadersRencontre($db,$mId[0]);
	}
}

function updatePrestationCollective($db,$matchId)
{
	global $SCO_minTpsCollectif;
	$getMatchData=$db->getArray("select club_dom_id, club_ext_id, buts_club_dom, buts_club_ext from rencontre where id={$matchId} limit 1");
	// Domicile
	$defense = getDefensePrestation($matchId,$getMatchData[0]['club_ext_id'],$getMatchData[0]['buts_club_ext'],$db);
	$attaque = getAttaquePrestation($matchId,$getMatchData[0]['club_dom_id'],$getMatchData[0]['buts_club_dom'],$db);
	// Pour toutes les prestations � domicile de ce match, mettre � jour:
	$listPrestationsId=$db->getArray("select pr.id, pr.minutes from prestation as pr where pr.match_id={$matchId} and pr.club_id={$getMatchData[0]['club_dom_id']}");
	if ($listPrestationsId != NULL)
	{
		foreach( $listPrestationsId as $prId )
		{
			$tempsDeJeu = 0;
			if ($prId['minutes'] != NULL) {
				$tempsDeJeu = intval($prId['minutes']);
			}
			if ($tempsDeJeu >= $SCO_minTpsCollectif) {
				$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prId['id']}");
				$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prId['id']}");
			} else {
				$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prId['id']}");
				$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prId['id']}");
			}
		}
	}
	// Exterieur
	$defense = getDefensePrestation($matchId,$getMatchData[0]['buts_club_dom'],$db);
	$attaque = getAttaquePrestation($matchId,$getMatchData[0]['buts_club_ext'],$db);
	// Pour toutes les prestations � l'ext�rieur de ce match, mettre � jour:
	$listPrestationsId=$db->getArray("select pr.id, pr.minutes from prestation as pr where pr.match_id={$matchId} and pr.club_id={$getMatchData[0]['club_ext_id']}");
	if ($listPrestationsId != NULL)
	{
		foreach( $listPrestationsId as $prId )
		{
			$tempsDeJeu = 0;
			if ($prId['minutes'] != NULL) {
				$tempsDeJeu = intval($prId['minutes']);
			}
			if ($tempsDeJeu >= $SCO_minTpsCollectif) {
				$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prId['id']}");
				$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prId['id']}");
			} else {
				$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prId['id']}");
				$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prId['id']}");
			}
		}
	}
}

// Enregistrement des stats.

function storeStatJoueur($db, $scoreJoueur,$sco1,$sco2,$joueurId,$journeeId) {
	if ($journeeId > 0) {
		$statLine = $db->getArray("select * from stats_joueurs where journee_id={$journeeId} and joueur_id={$joueurId}");
		if ($statLine != NULL) {
			// c'est un update
			$db->query("update stats_joueurs set score={$scoreJoueur},score1={$sco1},score2={$sco2} where joueur_id={$joueurId} and journee_id={$journeeId}");
		} else {
		 // c'est un insert
		 $db->query("insert into stats_joueurs(journee_id,joueur_id,score,score1,score2) values ({$journeeId},{$joueurId},{$scoreJoueur},{$sco1},{$sco2})");
		}
	}
}

function storeStatEkyp($db, $scoreEkyp,$sco1,$sco2,$ekypId,$journeeId) {
	$statLine = $db->getArray("select * from stats_ekyps where journee_id={$journeeId} and ekyp_id={$ekypId}");
	if ($statLine != NULL) {
		// c'est un update
		$db->query("update stats_ekyps set score={$scoreEkyp}, score1={$sco1}, score2={$sco2} where ekyp_id={$ekypId} and journee_id={$journeeId}");
	} else {
		// c'est un insert
		$db->query("insert into stats_ekyps(journee_id,ekyp_id,score,score1,score2) values ({$journeeId},{$ekypId},{$scoreEkyp},{$sco1},{$sco2})");
	}
}
?>