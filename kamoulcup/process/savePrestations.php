<?php
	include('checkAccess.php');
	checkAccess(2);
	include("../includes/db.php");
	include('api_score.php');
	include('validateForm.php');
	
	$journeeQuery = $db->getArray("select journee_id from rencontre where rencontre.id={$_POST['matchId']}");
	
// ----------------------------------------------------
//     POINT D'ENTREE ICI 
// ----------------------------------------------------
// Principe :
// 1) On met à jour la table 'buteurs' avec les identités des buteurs et passeurs du match en question
// 2) On enregistre les notes des joueurs
// 3) On met à jour les bonus défensifs (et offensifs) en remplissant la table 'prestation' à partir de la table 'buteurs'

	// Enregistrement des buteurs à domicile
	$nbButsDom = intval($_POST['nbButsDom']);
	
	for ($i=0;$i<$nbButsDom;$i++) {
			$idPasseur = 0;
			if(isNotNullOrEmpty($_POST['passeurButDom'][$i])) {
				$idPasseur = intval($_POST['passeurButDom'][$i]);
			}
			$isPenalty = 0;
			if (isset($_POST['penaltyButDom'][$i])) {
				$isPenalty = 1;
			}
			$isProlongation = 0;
			if (isset($_POST['prolongationButDom'][$i])) {
				$isProlongation = 1;
			}
			if ($_POST['nouveauButDom'][$i]) {
				insertButeur(intval($_POST['matchId']),intval($_POST['buteurButDom'][$i]),$idPasseur,$isPenalty,$isProlongation,'DOM',$db);
			} else {
				$butId = intval($_POST['idButDom'][$i]);
				updateButeur($butId,intval($_POST['matchId']),intval($_POST['buteurButDom'][$i]),$idPasseur,$isPenalty,$isProlongation,$db);
			}
	}
	// Enregistrement des buteurs à l'extérieur
	$nbButsExt = intval($_POST['nbButsExt']);

	for ($i=0;$i<$nbButsExt;$i++) {
			$idPasseur = 0;
			if(isNotNullOrEmpty($_POST['passeurButExt'][$i])) {
				$idPasseur = intval($_POST['passeurButExt'][$i]);
			}
			$isPenalty = 0;
			if (isset($_POST['penaltyButExt'][$i])) {
				$isPenalty = 1;
			}
			$isProlongation = 0;
			if (isset($_POST['prolongationButExt'][$i])) {
				$isProlongation = 1;
			}
			if ($_POST['nouveauButExt'][$i]) {
				insertButeur(intval($_POST['matchId']),intval($_POST['buteurButExt'][$i]),$idPasseur,$isPenalty,$isProlongation,'EXT',$db);
			} else {
				$butId = intval($_POST['idButExt'][$i]);
				updateButeur($butId,intval($_POST['matchId']),intval($_POST['buteurButExt'][$i]),$idPasseur,$isPenalty,$isProlongation,$db);
			}
	}
	
	// Enregistrement des prestations à domicile
		$defense = getDefensePrestation('EXT',$_POST['matchId'],$nbButsExt,$db);
		$attaque = getAttaquePrestation('DOM',$_POST['matchId'],$nbButsDom,$db);
	for ($i=0;$i<14;$i++) {
		if (isNotNullOrEmpty($_POST['playerDom'][$i])) {
			$player = $_POST['playerDom'][$i];
			$noteLE = NULL;
			if (isNotNullOrEmpty($_POST['noteLEDom'][$i])) {
				$noteLE = correctSlash($_POST['noteLEDom'][$i]);
				valideFloat($noteLE,'Note LEquipe Dom'.$i,'manageJournees');
			}
			$noteFF = NULL;
			if (isNotNullOrEmpty($_POST['noteFFDom'][$i])) {
				$noteFF = correctSlash($_POST['noteFFDom'][$i]);
				valideFloat($noteFF,'Note FF Dom'.$i,'manageJournees');
			}
			$noteSP = NULL;
			if (isNotNullOrEmpty($_POST['noteSPDom'][$i])) {
				$noteSP = correctSlash($_POST['noteSPDom'][$i]);
				valideFloat($noteSP,'Note SP Dom'.$i,'manageJournees');
			}
			$noteD = NULL;
			if (isNotNullOrEmpty($_POST['noteDDom'][$i])) {
				$noteD = correctSlash($_POST['noteDDom'][$i]);
				valideFloat($noteD,'Note D Dom'.$i,'manageJournees');
			}
			$noteE = NULL;
			if (isNotNullOrEmpty($_POST['noteEDom'][$i])) {
				$noteE = correctSlash($_POST['noteEDom'][$i]);
				valideFloat($noteE,'Note E Dom'.$i,'manageJournees');
			}
			$penObtenu = 0;
			if (isNotNullOrEmpty($_POST['penObtenuDom'][$i])) {
				$penObtenu = correctSlash($_POST['penObtenuDom'][$i]);
				valideInt($penObtenu,'Penaltys obtenus Dom'.$i,'manageJournees');
			}
			$tempsDeJeu = 0;
			if (isNotNullOrEmpty($_POST['minDom'][$i])) {
				$tempsDeJeu = correctSlash($_POST['minDom'][$i]);
				valideInt($tempsDeJeu,'Tps de jeu'.$i,'manageJournees');
			}
			$arretsDom = 0;
			if (isNotNullOrEmpty($_POST['arretsDom'][$i])) {
				$arretsDom = correctSlash($_POST['arretsDom'][$i]);
				valideInt($arretsDom,'arrêts Dom'.$i,'manageJournees');
			}
			$encaissesDom = 0;
			if (isNotNullOrEmpty($_POST['encaissesDom'][$i])) {
				$encaissesDom = correctSlash($_POST['encaissesDom'][$i]);
				valideInt($encaissesDom,'Encaissés Dom'.$i,'manageJournees');
			}
			$bonusDouble = isEliminationDirecte(intval($_POST['matchId']),$db);
			$prestationId = 0;;
			if ($_POST['nouveauDom'][$i]) {
				insertPrestation($player,$_POST['matchId'],$noteLE,$noteFF,$noteSP,$noteD,$noteE,$penObtenu,$_POST['clubDomId'],$db,$tempsDeJeu,$bonusDouble,$arretsDom,$encaissesDom);
				$prestationId = mysql_insert_id();
				if ($tempsDeJeu >= $SCO_minTpsCollectif) {
					$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prestationId}");
					$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prestationId}");
				} else {
					$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prestationId}");
					$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prestationId}");
				}
				updateButsPrestation($prestationId,$db);
			} else {
				$prestationId = $_POST['idDom'][$i];
				updatePrestation($_POST['idDom'][$i],$player,$_POST['matchId'],$noteLE,$noteFF,$noteSP,$noteD,$noteE,$penObtenu,$_POST['clubDomId'],$db,$tempsDeJeu,$bonusDouble,$arretsDom,$encaissesDom);
				if ($tempsDeJeu >= $SCO_minTpsCollectif) {
					$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prestationId}");
					$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prestationId}");
				} else {
					$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prestationId}");
					$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prestationId}");
				}
				updateButsPrestation($prestationId,$db);
			}
			calculScorePrestation($db,$prestationId);
			//Seul le score des joueurs transférés est calculé.
			//$joueurQuery = $db->getArray("select joueur_id from prestation where id={$prestationId} limit 1");
			//$joueurId = $joueurQuery[0][0];
			//calculScoreJoueur2($db,$joueurId);
		}
	}

// Enregistrement des prestations à l'extérieur
		$defense = getDefensePrestation('DOM',$_POST['matchId'],$nbButsDom,$db);
		$attaque = getAttaquePrestation('EXT',$_POST['matchId'],$nbButsExt,$db);
	for ($i=0;$i<14;$i++) {
		if (isNotNullOrEmpty($_POST['playerExt'][$i])) {
			$player = $_POST['playerExt'][$i];
			$noteLE = NULL;
			if (isNotNullOrEmpty($_POST['noteLEExt'][$i])) {
				$noteLE = correctSlash($_POST['noteLEExt'][$i]);
				valideFloat($noteLE,'Note LEquipe Ext'.$i,'manageJournees');
			}
			$noteFF = NULL;
			if (isNotNullOrEmpty($_POST['noteFFExt'][$i])) {
				$noteFF = correctSlash($_POST['noteFFExt'][$i]);
				valideFloat($noteFF,'Note FF Ext'.$i,'manageJournees');
			}$noteSP = NULL;
			if (isNotNullOrEmpty($_POST['noteSPExt'][$i])) {
				$noteSP = correctSlash($_POST['noteSPExt'][$i]);
				valideFloat($noteSP,'Note SP Ext'.$i,'manageJournees');
			}
			
			$noteD = NULL;
			if (isNotNullOrEmpty($_POST['noteDExt'][$i])) {
				$noteD = correctSlash($_POST['noteDExt'][$i]);
				valideFloat($noteD,'Note D Ext'.$i,'manageJournees');
			}
			$noteE = NULL;
			if (isNotNullOrEmpty($_POST['noteEExt'][$i])) {
				$noteE = correctSlash($_POST['noteEExt'][$i]);
				valideFloat($noteE,'Note E Ext'.$i,'manageJournees');
			}
			$penObtenu = 0;
			if (isNotNullOrEmpty($_POST['penObtenuExt'][$i])) {
				$penObtenu = correctSlash($_POST['penObtenuExt'][$i]);
				valideInt($penObtenu,'Pénaltys obtenus Ext'.$i,'manageJournees');
			}
			$tempsDeJeu = 0;
			if (isNotNullOrEmpty($_POST['minExt'][$i])) {
				$tempsDeJeu = correctSlash($_POST['minExt'][$i]);
				valideInt($tempsDeJeu,'Tps de jeu'.$i,'manageJournees');
			}
			$arretsExt = 0;
			if (isNotNullOrEmpty($_POST['arretsExt'][$i])) {
				$arretsExt = correctSlash($_POST['arretsExt'][$i]);
				valideInt($arretsExt,'arrêts ext'.$i,'manageJournees');
			}
			$encaissesExt = 0;
			if (isNotNullOrEmpty($_POST['encaissesExt'][$i])) {
				$encaissesExt = correctSlash($_POST['encaissesExt'][$i]);
				valideInt($encaissesExt,'Encaissés ext'.$i,'manageJournees');
			}
			$bonusDouble = isEliminationDirecte(intval($_POST['matchId']),$db);
			$prestationId = 0;
			if ($_POST['nouveauExt'][$i]) {
				insertPrestation($player,$_POST['matchId'],$noteLE,$noteFF,$noteSP,$noteD,$noteE,$penObtenu,$_POST['clubExtId'],$db,$tempsDeJeu,$bonusDouble,$arretsExt,$encaissesExt);
				$prestationId = mysql_insert_id();
				if ($tempsDeJeu >= $SCO_minTpsCollectif) {
					$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prestationId}");
					$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prestationId}");
				} else {
					$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prestationId}");
					$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prestationId}");
				}
				updateButsPrestation($prestationId,$db);
			} else {
				$prestationId = $_POST['idExt'][$i];
				updatePrestation($_POST['idExt'][$i],$player,$_POST['matchId'],$noteLE,$noteFF,$noteSP,$noteD,$noteE,$penObtenu,$_POST['clubExtId'],$db,$tempsDeJeu,$bonusDouble,$arretsExt,$encaissesExt);
				if ($tempsDeJeu >= $SCO_minTpsCollectif) {
					$db->query("update prestation set defense_vierge='{$defense['vierge']}', defense_unpenalty='{$defense['unpeno']}', defense_unbut='{$defense['unbut']}' where id={$prestationId}");
					$db->query("update prestation set troisbuts='{$attaque['troisbuts']}', troisbuts_unpenalty='{$attaque['unpeno']}' where id={$prestationId}");
				} else {
					$db->query("update prestation set defense_vierge=0, defense_unpenalty=0, defense_unbut=0 where id={$prestationId}");
					$db->query("update prestation set troisbuts=0, troisbuts_unpenalty=0 where id={$prestationId}");
				}
				updateButsPrestation($prestationId,$db);
			}
			calculScorePrestation($db,$prestationId);
			//Seul le score des joueurs transférés est calculé.
			//$joueurQuery = $db->getArray("select joueur_id from prestation where id={$prestationId} limit 1");
			//$joueurId = $joueurQuery[0][0];
			//calculScoreJoueur2($db,$joueurId);
		}
	}
	calculLeadersRencontre($db,$_POST['matchId']);
	calculScoresToutesEkyps($db);
	//header('Location: ../index.php?page=manageJournees');
	echo "<script>window.location.replace('../index.php?page=manageJournees');</script>";
	exit();
?>