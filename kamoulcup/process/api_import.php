<?php

function importRencontres($token, $uuid_journee) {
	global $SN_host;
	global $db;
	$resultatsJourneeUrl = 'http://'.$SN_host.'/rest/steps/'.$uuid_journee.'/?expand=meetings';
	$json = _getProtectedUrl($token, $resultatsJourneeUrl);
	// Création de la nouvelle journée
	// Ou récupération de l'existante si elle existe.
	$getJourneeQ = "select id,eliminatoire from journee where uuid='{$uuid_journee}'";
	$getJournee = $db->getArray($getJourneeQ);
	if ($getJournee == NULL) {
		$dateJournee = $json->meetings[0]->date;
		$num = $json->name;
		$newJourneeQ = "insert into journee(numero, uuid, date) value ({$num},'{$uuid_journee}','{$dateJournee}')";
		$db->query($newJourneeQ);
		$getJourneeQ = "select id from journee where uuid='{$uuid_journee}'";
		$getJournee = $db->getArray($getJourneeQ);
	}
	$journeeId = $getJournee[0][0];
	$dbl = $getJournee[0][1];
	// insertion des rencontres
	// On ne s'occupe pas des prestations à cet endroit
	for($i=0; $i < count($json->meetings); $i++) {
		$homeg = $json->meetings[$i]->home_result;
		$awayg = $json->meetings[$i]->away_result;
		$homeuuid = $json->meetings[$i]->home_team;
		$awayuuid = $json->meetings[$i]->away_team;
		$insertQ = "insert into rencontre(club_dom_id,club_ext_id,buts_club_dom,buts_club_ext,journee_id,elimination) select clDom.id, clExt.id, {$homeg}, {$awayg}, {$journeeId}, 0 from club as clDom inner join club as clExt where clDom.uuid='{$homeuuid}' and clExt.uuid='{$awayuuid}' on duplicate key update buts_club_dom={$homeg}, buts_club_ext={$awayg}";
		$db->query($insertQ);
	}
	// mise à jour des prestations
	for($i=0; $i < count($json->meetings); $i++) {
		$meetinguuid = $json->meetings[$i]->uuid;
		importPrestations($token, $meetinguuid, $journeeId, $dbl);
	}

	$db->query("update journee set last_sync=now(), sync_me=0 where uuid='{$uuid_journee}'");
}

function importPrestations($token, $uuid_meeting, $journeeId, $dbl_bonus) {
	global $SN_host;
	global $SN_src_WS;
	global $SN_src_OS;
	global $SN_src_SP;
	global $SCO_minTpsCollectif;
	global $SCO_minTps;
	global $db;
	$meetingUrl = 'http://'.$SN_host.'/rest/footballmeetings/'.$uuid_meeting.'/';
	$json = _getProtectedUrl($token, $meetingUrl);
	// Init du tableau des bonus.
	$team_bonus = array(
		'home' => array(
			'cs' => False,
			'cs_demi_possible' => False,
			'cd_demi' => False,
			'offensif' => False,
			'offensif_demi_possible' => False,
			'offensif_demi' => False
	),
		'away' => array(
			'cs' => False,
			'cs_demi_possible' => False,
			'cd_demi' => False,
			'offensif' => False,
			'offensif_demi_possible' => False,
			'offensif_demi' => False
	)
	);
	// Affectation home/away
	$homeuuid = $json->home_team->uuid;
	$awayuuid = $json->away_team->uuid;
	$affectation = array (
	$homeuuid => 'home',
	$awayuuid => 'away'
	);
	// Etude des resultats
	if ($json->home_result == 0) {
		$team_bonus['away']['cs'] = True;
	}
	if ($json->home_result == 1) {
		$team_bonus['away']['cs_demi_possible'] = True;
	}
	if ($json->home_result == 3) {
		$team_bonus['home']['offensif_demi_possible'] = True;
	}
	if ($json->home_result > 3) {
		$team_bonus['home']['offensif'] = True;
	}
	if ($json->away_result == 0) {
		$team_bonus['home']['cs'] = True;
	}
	if ($json->away_result == 1) {
		$team_bonus['home']['cs_demi_possible'] = True;
	}
	if ($json->away_result == 3) {
		$team_bonus['away']['offensif_demi_possible'] = True;
	}
	if ($json->away_result > 3) {
		$team_bonus['away']['offensif'] = True;
	}
	$countPeno = array ('home' => 0, 'away' => 0);
	// Le match existe déjà forcément en bd
	$getMatchQ = "select rencontre.id, clDom.id, clExt.id from rencontre inner join club as clDom on clDom.id=club_dom_id inner join club as clExt on clExt.id=club_ext_id where journee_id={$journeeId} and clDom.uuid='{$homeuuid}' and clExt.uuid='{$awayuuid}' limit 1";
	$getMatch = $db->getArray($getMatchQ);
	$matchId = $getMatch[0][0];
	$domId = $getMatch[0][1];
	$extId = $getMatch[0][2];
	$maxNote = array('home' => array('D' => 0.0, 'M' => 0.0), 'away' => array('D' => 0.0, 'M' => 0.0));
	$maxJoueurId = array('home' => array('D' => array(), 'M' => array()), 'away' => array('D' => array(), 'M' => array()));

	for($i=0; $i < count($json->roster); $i++) {
		$current = $json->roster[$i];
		$uuid = $current->player->uuid;
		// Récupération du joueur ou création s'il n'existe pas:
		$getClubQ = "select id from club where uuid='{$current->played_for}'";
		$getClub = $db->getArray($getClubQ);
		$cl = $getClub[0][0];
		$getJoueur = $db->getArray("select id, poste, club_id from joueur where uuid='{$uuid}'");
		if ($getJoueur == NULL) {
			// Création du joueur.
			if (property_exists($current->player, 'usual_name') && strlen($current->player->usual_name)>0) {
				$fn = NULL;
				$ln =  htmlspecialchars($current->player->usual_name, ENT_COMPAT, 'UTF-8');
			} else {
				if (property_exists($current->player, 'first_name')) {
					$fn = htmlspecialchars($current->player->first_name, ENT_COMPAT, 'UTF-8');
				} else {
					$fn = NULL;
				}
				$ln =  htmlspecialchars($current->player->last_name, ENT_COMPAT, 'UTF-8');
			}
			$createJoueurQ = "insert into joueur(prenom,nom,uuid,club_id) select '{$fn}', '{$ln}', '{$uuid}', id from club where uuid='{$current->played_for}'";
			$db->query($createJoueurQ);
			$getJoueur = $db->getArray("select id,poste from joueur where uuid='{$uuid}'");
		} else {
			// Update club_id si club différent
			$oldcl = $getJoueur[0][2];
			if ($oldcl != $cl) {
				$updateJoueurQ = "update joueur set club_id={$cl} where uuid='{$uuid}'";
				$db->query($updateJoueurQ);
			}
		}
		$joueurId = $getJoueur[0][0];
		$joueurPoste = $getJoueur[0][1];

		$countPeno[$affectation[($current->played_for)]] += $current->stats->penalties_scored;
		// On peut insérer les stats individuelles dans la boucle,
		// on réserve les stats collectives pour la fin
		$noteEQ = 'NULL';
		$noteWS = 'NULL';
		$noteSP = 'NULL';
		$noteKI = 'NULL';
		$sommeNotes = 0;
		$nbNotes = 0;
		for ($j=0; $j<count($current->ratings); $j++) {
			if ($current->ratings[$j]->source == $SN_src_OS) {
				$noteEQ = 0.0 + $current->ratings[$j]->rating;
				$sommeNotes += $noteEQ;
				$nbNotes++;
			}
			if ($current->ratings[$j]->source == $SN_src_WS) {
				$noteWS = 0.0 + $current->ratings[$j]->rating;
				$sommeNotes += convertNoteWS($noteWS);
				$nbNotes++;
			}
			if ($current->ratings[$j]->source == $SN_src_SP) {
				$noteSP = 0.0 + $current->ratings[$j]->rating;
				$sommeNotes += $noteSP;
				$nbNotes++;
			}
		}
		if ($current->stats->playtime >= $SCO_minTps) {
			if ($nbNotes > 0 && ($joueurPoste == 'D' || $joueurPoste == 'M') ) {
				$moy = $sommeNotes / $nbNotes;
				if ($moy > $maxNote[$affectation[$current->played_for]][$joueurPoste]) {
					$maxJoueurId[$affectation[$current->played_for]][$joueurPoste] = array($joueurId);
					$maxNote[$affectation[$current->played_for]][$joueurPoste] = $moy;
				} else if ($moy == $maxNote[$affectation[$current->played_for]][$joueurPoste]) {
					array_push($maxJoueurId[$affectation[$current->played_for]][$joueurPoste], $joueurId);
				}
			}
		}
		$insertPrestaQ = "insert into prestation(joueur_id, match_id, club_id, note_lequipe, note_ff, note_sp, note_d, but_marque, passe_dec, penalty_marque, penalty_obtenu, minutes, arrets, encaisses, double_bonus) select {$joueurId}, {$matchId}, club_id, {$noteEQ}, {$noteWS}, {$noteSP}, {$noteKI}, {$current->stats->goals_scored}, {$current->stats->goals_assists}, {$current->stats->penalties_scored}, {$current->stats->penalties_awarded}, {$current->stats->playtime}, {$current->stats->goals_saved}, {$current->stats->goals_conceded}, {$dbl_bonus} from joueur where id={$joueurId} on duplicate key update note_lequipe={$noteEQ}, note_ff={$noteWS}, note_sp={$noteSP}, note_d={$noteKI}, but_marque={$current->stats->goals_scored}, passe_dec={$current->stats->goals_assists}, penalty_marque={$current->stats->penalties_scored}, penalty_obtenu={$current->stats->penalties_awarded}, minutes={$current->stats->playtime}, arrets={$current->stats->goals_saved}, encaisses={$current->stats->goals_conceded}, double_bonus={$dbl_bonus}";
		$db->query($insertPrestaQ);

		// Bonus collectifs
		if ($team_bonus['home']['cs_demi_possible'] == True && $countPeno['away'] == 1) {
			$team_bonus['home']['cs_demi'] = True;
		}
		if ($team_bonus['away']['cs_demi_possible'] == True && $countPeno['home'] == 1) {
			$team_bonus['away']['cs_demi'] = True;
		}
		if ($team_bonus['home']['offensif_demi_possible'] == True && $countPeno['home'] == 0) {
			$team_bonus['home']['offensif'] = True;
		}
		if ($team_bonus['home']['offensif_demi_possible'] == True && $countPeno['home'] == 1) {
			$team_bonus['home']['offensif_demi'] = True;
		}
		if ($team_bonus['away']['offensif_demi_possible'] == True && $countPeno['away'] == 0) {
			$team_bonus['away']['offensif'] = True;
		}
		if ($team_bonus['away']['offensif_demi_possible'] == True && $countPeno['away'] == 1) {
			$team_bonus['away']['offensif_demi'] = True;
		}
	}
	// Mise à jour des bonus collectifs
	// D'abord : mise à zéro
	$db->query("update prestation set defense_unpenalty=0, defense_vierge=0, troisbuts=0, troisbuts_unpenalty=0 where match_id={$matchId}");

	if ($team_bonus['home']['cs_demi'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set defense_unpenalty=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}
	elseif ($team_bonus['home']['cs'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set defense_vierge=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}
	if ($team_bonus['home']['offensif_demi'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set troisbuts_unpenalty=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}
	elseif ($team_bonus['home']['offensif'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set troisbuts=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}


	if ($team_bonus['away']['cs_demi'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set defense_unpenalty=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}
	elseif ($team_bonus['away']['cs'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set defense_vierge=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}
	if ($team_bonus['away']['offensif_demi'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set troisbuts_unpenalty=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	} elseif ($team_bonus['away']['offensif'] == True) {
		$bonusQ = "update prestation inner join club on club_id=club.id set troisbuts=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and minutes>={$SCO_minTpsCollectif}";
		$db->query($bonusQ);
	}


	// Mise à jour des bonus de meilleur joueur
	// D'abord : mise à zéro
	$db->query("update prestation set leader=0 where match_id={$matchId}");
	for ($i=0; $i<count($maxJoueurId['home']['D']); $i++) {
		$joueurId = $maxJoueurId['home']['D'][$i];
		$bonusQ = "update prestation inner join club on club_id=club.id set leader=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and joueur_id={$joueurId}";
		$db->query($bonusQ);
	}
	for ($i=0; $i<count($maxJoueurId['home']['M']); $i++) {
		$joueurId = $maxJoueurId['home']['M'][$i];
		$bonusQ = "update prestation inner join club on club_id=club.id set leader=1 where match_id={$matchId} and club.uuid='{$homeuuid}' and joueur_id={$joueurId}";
		$db->query($bonusQ);
	}
	for ($i=0; $i<count($maxJoueurId['away']['D']); $i++) {
		$joueurId = $maxJoueurId['away']['D'][$i];
		$bonusQ = "update prestation inner join club on club_id=club.id set leader=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and joueur_id={$joueurId}";
		$db->query($bonusQ);
	}
	for ($i=0; $i<count($maxJoueurId['away']['M']); $i++) {
		$joueurId = $maxJoueurId['away']['M'][$i];
		$bonusQ = "update prestation inner join club on club_id=club.id set leader=1 where match_id={$matchId} and club.uuid='{$awayuuid}' and joueur_id={$joueurId}";
		$db->query($bonusQ);
	}
}

function listJournees($token, $uuid_instance) {
	global $SN_host;
	$journeesUrl = 'http://'.$SN_host.'/rest/tournament_instances/'.$uuid_instance.'/?expand=steps';
	return _getProtectedUrl($token, $journeesUrl);
}

function getAccessToken() {
	global $SN_host;
	global $SN_client_id;
	global $SN_client_secret;
	global $SN_access_path;
	$accessUrl = 'https://'.$SN_host.$SN_access_path;
	// Init cUrl.
	$r = _initCurl($accessUrl);
	// Add client ID and client secret to the headers.
	curl_setopt($r, CURLOPT_HTTPHEADER, array (
            "Authorization: Basic " . base64_encode($SN_client_id . ":" . $SN_client_secret),
	));
	// Assemble POST parameters for the request.
	$post_fields = "grant_type=client_credentials";
	// Obtain and return the access token from the response.
	curl_setopt($r, CURLOPT_POST, true);
	curl_setopt($r, CURLOPT_POSTFIELDS, $post_fields);
	$response = curl_exec($r);
	if ($response == false) {
		die("curl_exec() failed. Error: " . curl_error($r));
	}
	//Parse JSON return object.
	$auth_data = json_decode($response);
	$token_type = $auth_data->token_type;
	$token_value = $auth_data->access_token;
	return $token_type.' '.$token_value;
}

function getClubWithMembers($token, $uuidClub) {
	global $SN_host;
	$plUrl = 'http://'.$SN_host.'/rest/football_teams/'.$uuidClub.'/?expand=members';
	return _getProtectedUrl($token, $plUrl);
}


//=========================== Private ==================================================
function _initCurl($url) {
	$r = null;
	if (($r = @curl_init($url)) == false) {
		header("HTTP/1.1 500", true, 500);
		die("Cannot initialize cUrl session. Is cUrl enabled for your PHP installation?");
	}
	curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
	// Decode compressed responses.
	curl_setopt($r, CURLOPT_ENCODING, 1);
	// NOTE: If testing locally, add the following lines to use a dummy certificate, and to prevent cUrl from attempting to verify
	// the certificate's authenticity. See http://richardwarrender.com/2007/05/the-secret-to-curl-in-php-on-windows/ for more
	// details on this workaround. If your server has a valid SSL certificate installed, comment out these lines.
	curl_setopt($r, CURLOPT_SSL_VERIFYPEER, false);
	//curl_setopt($r, CURLOPT_CAINFO, "C:\wamp\bin\apache\Apache2.2.21\cacert.crt");
	// NOTE: For Fiddler2 debugging.
	//curl_setopt($r, CURLOPT_PROXY, '127.0.0.1:8888');++++++++++
	return($r);
}

function _getProtectedUrl($token, $url) {
	$r = _initCurl($url);
	curl_setopt($r, CURLOPT_HTTPHEADER, array (
            "Authorization: " . $token,
	));
	$response = curl_exec($r);
	if ($response == false) {
		die("curl_exec() failed. Error: " . curl_error($r));
	}
	//Parse JSON return object.
	return json_decode($response);
}
?>