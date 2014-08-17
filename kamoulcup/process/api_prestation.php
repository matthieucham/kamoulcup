<?php

	function insertPrestation($joueurId,$matchId,$noteLequipe,$noteFF,$noteSP,$noteD,$noteE,$penaltyObtenu,$clubId, $db, $minutes, $double, $arr, $det) {
		if (strlen($noteLequipe)==0) {
			$noteLequipe='NULL';
		} else {
			$noteLequipe=round($noteLequipe,1);
		}
		if (strlen($noteFF)==0) {
			$noteFF='NULL';
		} else {
			$noteFF=round($noteFF,1);
		}
		if (strlen($noteSP)==0) {
			$noteSP='NULL';
		} else {
			$noteSP=round($noteSP,1);
		}
		if (strlen($noteD)==0) {
			$noteD='NULL';
		} else {
			$noteD=round($noteD,1);
		}
		if (strlen($noteE)==0) {
			$noteE='NULL';
		} else {
			$noteE=round($noteE,1);
		}
		$query = $db->query("insert into prestation(joueur_id,match_id,note_lequipe,note_ff,note_sp,note_d,note_e,but_marque,passe_dec,penalty_marque,club_id,penalty_obtenu,minutes,double_bonus,arrets,encaisses) values ('{$joueurId}','{$matchId}',{$noteLequipe},{$noteFF},{$noteSP},{$noteD},{$noteE},0,0,0,'{$clubId}','{$penaltyObtenu}',{$minutes},{$double},{$arr},{$det})") or die ('Error, insert query failed');
	}
	
	function updatePrestation($id,$joueurId,$matchId,$noteLequipe,$noteFF,$noteSP,$noteD,$noteE,$penaltyObtenu,$clubId, $db, $minutes, $double, $arr, $det) {
		if (strlen($noteLequipe)==0) {
			$noteLequipe='NULL';
		} else {
			$noteLequipe=round($noteLequipe,1);
		}
		if (strlen($noteFF)==0) {
			$noteFF='NULL';
		} else {
			$noteFF=round($noteFF,1);
		}
		if (strlen($noteSP)==0) {
			$noteSP='NULL';
		} else {
			$noteSP=round($noteSP,1);
		}
		if (strlen($noteD)==0) {
			$noteD='NULL';
		} else {
			$noteD=round($noteD,1);
		}
		if (strlen($noteE)==0) {
			$noteE='NULL';
		} else {
			$noteE=round($noteE,1);
		}
		$query = $db->query("update prestation set joueur_id='{$joueurId}', match_id='{$matchId}', note_lequipe={$noteLequipe}, note_ff={$noteFF}, note_sp={$noteSP}, note_d={$noteD}, note_e={$noteE}, but_marque=0, passe_dec=0, penalty_marque=0, club_id='{$clubId}', penalty_obtenu='{$penaltyObtenu}', minutes={$minutes}, double_bonus={$double}, arrets={$arr}, encaisses={$det} where id='{$id}'") or die ('Error, update query failed');
	}
	
	function getDefensePrestation($domExt,$match,$butsEncaisses,$db) {
		$defensePrestation = array('vierge' => 0, 'unpeno' => 0, 'unbut' => 0);
		if ($butsEncaisses > 1) {
			return $defensePrestation;
		}
		if ($butsEncaisses == 0) {
			$defensePrestation['vierge'] = 1;
			$defensePrestation['unpeno'] = 0;
			$defensePrestation['unbut'] = 0;
			return $defensePrestation;
		}
		if ($butsEncaisses == 1) {
			$query = $db->getArray("select penalty,prolongation from buteurs where rencontre_id={$match} and dom_ext='{$domExt}'");
			$penos = 0;
			if ($query != NULL) {
				foreach($query as $peno){
					$penos += intval("0".$peno[0]);
				}
			}
			if ($penos == 1){
				$defensePrestation['vierge'] = 0;
				$defensePrestation['unbut'] = 0;
				$defensePrestation['unpeno'] = 1;
			} else {
				$defensePrestation['vierge'] = 0;
				$defensePrestation['unpeno'] = 0;
				$defensePrestation['unbut'] = 1;
			}
			return $defensePrestation;
		}
	}
	
	function getAttaquePrestation($domExt,$match,$butsMarques,$db) {
		$attaquePrestation = array('troisbuts' => 0, 'unpeno' => 0);
		if ($butsMarques < 3) {
			return $attaquePrestation;
		}
		if ($butsMarques > 3) {
			$attaquePrestation['troisbuts'] = 1;
			return $attaquePrestation;
		}
		$query = $db->getArray("select penalty,prolongation from buteurs where rencontre_id={$match} and dom_ext='{$domExt}'");
		//$query = $db->getArray("select penalty_marque from prestation where match_id='{$match}' and club_id='{$clubId}'");
		$penos = 0;
		if ($query != NULL) {
			foreach($query as $peno){
					$penos += intval($peno[0]);
			}
		}
		if ($penos == 1){
				$attaquePrestation['unpeno'] = 1;
				return $attaquePrestation;
		}
		if ($penos == 0){
			$attaquePrestation['troisbuts'] = 1;
			return $attaquePrestation;
		}
		if ($penos > 1) {
			$attaquePrestation['unpeno'] = 0;
			$attaquePrestation['troisbuts'] = 0;
			return $attaquePrestation;
		}
	}
	
	function isNotNullOrEmpty($varToCheck) {
		if (! isset($varToCheck)) {
			return 0;
		} else {
			return (strlen($varToCheck) > 0);
		}
	}

	function isEliminationDirecte($matchId,$db)
  {
  	$query = $db->getArray("select elimination from rencontre where id={$matchId} limit 1");
  	if ($query != NULL){
  		return $query[0][0];
  	} else {
  		return 0;
  	}
  }
  
  function insertButeur($matchId,$buteurId,$passeurId,$isPenalty,$isProlongation,$domExt,$db) {
		$query = $db->query("insert into buteurs(rencontre_id,dom_ext,buteur_id,passeur_id,penalty,prolongation) values ({$matchId},'{$domExt}',{$buteurId},{$passeurId},{$isPenalty},{$isProlongation})") or die ('Error, insert query failed');
	}

	function updateButeur($id,$matchId,$buteurId,$passeurId,$isPenalty,$isProlongation,$db) {
		$query = $db->query("update buteurs set rencontre_id={$matchId}, buteur_id={$buteurId}, passeur_id={$passeurId}, penalty={$isPenalty}, prolongation={$isProlongation} where id={$id}") or die ('Error, update query failed');
	}
	
	function updateButsPrestation($prestationId,$db) {
		$getButeursQuery = $db->getArray("select bu.buteur_id,bu.passeur_id,bu.penalty,pr.joueur_id,pr.penalty_obtenu from buteurs as bu, prestation as pr where bu.rencontre_id=pr.match_id and (bu.buteur_id=pr.joueur_id or bu.passeur_id=pr.joueur_id) and pr.id={$prestationId}");
		if ($getButeursQuery == NULL) {
			// Pas de but ni de passe pour ce joueur : on sort
			return;
		}
		$cptBut=0;
		$cptPeno=0;
		$cptPasse=0;
		$cptPenoObt=$getButeursQuery[0]['penalty_obtenu'];
		foreach($getButeursQuery as $bRow) {
			if ($bRow['penalty']) {
				if ($bRow['buteur_id'] == $bRow['joueur_id']) {
					$cptPeno++;
				}
				// Le penalty est le seul cas de figure où l'on peut se faire une passe décisive à soit meme, donc pas de 'else' ici.
				if ($bRow['passeur_id'] == $bRow['joueur_id']){
					$cptPenoObt++;
				}
			} else {
				if ($bRow['buteur_id'] == $bRow['joueur_id']) {
					$cptBut++;
				} else if ($bRow['passeur_id'] == $bRow['joueur_id']){
					$cptPasse++;
				}
			}
		}
		// enregistrement des valeurs obtenues dans la table prestation
		$db->query("update prestation set but_marque={$cptBut}, passe_dec={$cptPasse}, penalty_marque={$cptPeno},penalty_obtenu={$cptPenoObt} where id={$prestationId}");
	}
	
	// Met à jour le flag "leader" de la talbe prestation pour enregistrer les leaders de chaque ligne du match concerné.
	function calculLeadersRencontre($db,$rencontreId) {
		// il faut connaitre le club dom et le club ext.
		$clubsQuery = $db->getArray("select club_dom_id, club_ext_id from rencontre where id={$rencontreId}");
		$clubDomId = $clubsQuery[0][0];
		$clubExtId = $clubsQuery[0][1];
		// les gardiens
		//$gardiensQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='G' and pr.score>0");
		//setLeader($db,$gardiensQuery);
		// défenseurs (tous)
		//$defQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='D' and pr.score>0");
		//setLeader($db,$defQuery);
		// milieux (tous)
		//$milQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='M' and pr.score>0");
		//setLeader($db,$milQuery);
		// attaquants (tous)
		//$attQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='A' and pr.score>0");
		//setLeader($db,$attQuery);
		// les defenseurs à domicile
		$defDomQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='D' and jo.club_id={$clubDomId} and pr.score>0");
		setLeader($db,$defDomQuery);
		// les defenseurs à l'extérieur
		$defExtQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='D' and jo.club_id={$clubExtId} and pr.score>0");
		setLeader($db,$defExtQuery);
		// les milieux à domicile
		$milDomQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='M' and jo.club_id={$clubDomId} and pr.score>0");
		setLeader($db,$milDomQuery);
		// les milieux à l'extérieur
		$milExtQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='M' and jo.club_id={$clubExtId} and pr.score>0");
		setLeader($db,$milExtQuery);
		// les attaquants à domicile
		//$attDomQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='A' and jo.club_id={$clubDomId} and pr.score>0");
		//setLeader($db,$attDomQuery);
		// les attaquants à l'extérieur
		//$attExtQuery = $db->getArray("select pr.id, pr.score, pr.minutes from prestation pr, joueur jo where pr.match_id={$rencontreId} and pr.joueur_id=jo.id and jo.poste='A' and jo.club_id={$clubExtId} and pr.score>0 and pr.minutes>={$SCO_minTps}");
		//setLeader($db,$attExtQuery);
	}
	
	// Met à 1 le flag leader de la meilleure (ou des meilleures) prestation en param, et remet les autres à 0
	function setLeader($db,$prestationsArray) {
		global $SCO_minTps;
	// repérer la prestation la plus haute et mettre à jour son flag.
		if ($prestationsArray != NULL) {
			$bestIds = Array();
			$bestScore=0;
			foreach($prestationsArray as $prest) {
				$db->query("update prestation set leader=0 where id={$prest[0]}");
				$currScore = round(floatval($prest[1]),2);
				$minutes = floatval($prest[2]);
				if ($minutes >= $SCO_minTps)
				{
				if ($currScore == $bestScore) {
					array_push($bestIds,$prest[0]);
				}
				if ($currScore > $bestScore) {
					$bestIds = Array();
					$bestScore= $currScore;
					array_push($bestIds,$prest[0]);
				}
			}
				// si score inférieur, on ne fait rien
			}
			// Puis on met les flag leader à 1
			foreach($bestIds as $best) {
				$db->query("update prestation set leader=1 where id={$best}");
			}
		}
	}
?>