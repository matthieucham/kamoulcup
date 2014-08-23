<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/api_score.php');
	include('../../../process/validateForm.php');

	$journeeId = correctSlash($_POST['journee']);
	// 0) Donner une perf à chacun avec une valeur initiale de 0
	// 	1) Récupérer les performances de la journée choisie
	$selectQ = "select joueur_id,match_id,prestation.score,but_marque,passe_dec,penalty_marque,penalty_obtenu,defense_vierge,defense_unpenalty,defense_unbut,troisbuts,troisbuts_unpenalty,minutes,double_bonus,leader,arrets,encaisses,jo.poste from prestation, joueur jo where jo.id=joueur_id and match_id in (select id from rencontre where journee_id={$journeeId})";
	$prestations = $db->getArray($selectQ);
	
	if($prestations != NULL) {
		foreach($prestations as $prestation) {
			// 2) Calculer les points marqués par chaque joueur
			$points = calculPointsJoueur($prestation);
			// 3) Enregistrer les points en db
			$joueurId = $prestation['joueur_id'];
			$matchId = $prestation['match_id'];
			$updateQ = "insert into km_joueur_perf (jpe_joueur_id,jpe_match_id,jpe_score) values ({$joueurId},{$matchId},{$points}) on duplicate key update jpe_score={$points}";
			$db->query($updateQ);
		}
	}
	
	// 4) calculer les points marqués par chaque ekyp à chaque journée
	$ekypQ = "SELECT eng_ekyp_id,{$journeeId},sum(jpe_score) as ekScore FROM km_joueur_perf inner join km_engagement on eng_joueur_id=jpe_joueur_id inner join km_selection_ekyp_match on sem_engagement_id=eng_id where jpe_match_id in (select id from rencontre where journee_id={$journeeId}) and jpe_match_id=sem_match_id group by eng_ekyp_id";
	$updateEkypScoreQ = "insert into km_ekyp_score(eks_ekyp_id,eks_journee_id,eks_score) {$ekypQ} on duplicate key update eks_score=values(eks_score)";
	$db->query($updateEkypScoreQ);
	
	header('Location: ../index.php');
	exit();
	
	
	function calculPointsJoueur($presta) {
		global $NOT_leader;
		global $NOT_defvierge;
		global $NOT_defunpenalty;
		global $NOT_defunbut;
		global $NOT_arret;
		global $NOT_encaisse;
		global $NOT_troisbuts;
		global $NOT_troisbutsunpenalty;
		global $NOT_but;
		global $NOT_penalty;
		global $NOT_passedec;
		global $NOT_penaltyobtenu;
		global $SCO_minTps;
		global $SCO_minTpsCollectif;
		global $SCO_tpsEntreeCourte;
		global $SCO_noteEC;
		global $SCO_noteEL;
		
		$note = 0;
		if (intval($presta['minutes']) < $SCO_tpsEntreeCourte) {
			$note = $SCO_noteEC;
		} else if (intval($presta['minutes']) < $SCO_minTps) {
			$note = $SCO_noteEL;
		} else {
			$note =  floatval($presta['score']);
		}
		
		$bonus = 0;
		$poste = $presta['poste'];
		// Bonus collectifs
		if (intval($presta['minutes']) >= $SCO_minTpsCollectif) {
			$bonus += (intval($presta['defense_vierge'])*$NOT_defvierge[$poste]);
			$bonus += (intval($presta['defense_unpenalty'])*$NOT_defunpenalty[$poste]);
			$bonus += (intval($presta['defense_unbut'])*$NOT_defunbut[$poste]);
			$bonus += (intval($presta['troisbuts'])*$NOT_troisbuts[$poste]);
			$bonus += (intval($presta['troisbuts_unpenalty'])*$NOT_troisbutsunpenalty[$poste]);
			$bonus += (intval($presta['leader'])*$NOT_leader[$poste]);
		}
		
		// Bonus individuels
		$bonus += (intval($presta['arrets'])*$NOT_arret[$poste]);
		$bonus += (intval($presta['encaisses'])*$NOT_encaisse[$poste]);
		$bonus += (intval($presta['but_marque'])*$NOT_but);
		$bonus += (intval($presta['passe_dec'])*$NOT_passedec);
		$bonus += (intval($presta['penalty_marque'])*$NOT_penalty);
		$bonus += (intval($presta['penalty_obtenu'])*$NOT_penaltyobtenu);
		
		if (intval($presta['double_bonus'])>0) {
			$bonus *= 2;
		}
		
		return $bonus + $note;
	}
?>