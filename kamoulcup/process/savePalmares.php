<?php
	include('checkAccess.php');
	checkAccess(4);
	include("../includes/db.php");
	include('validateForm.php');
	
	function getEffectif($ekypId, $nbG, $nbD, $nbM, $nbA, $scTxt) {
		global $db;
		$listGQuery = $db->getArray("select jo.nom from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='G' order by score{$scTxt} desc limit {$nbG}");
		$listDQuery = $db->getArray("select jo.nom from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='D' order by score{$scTxt} desc limit {$nbD}");
		$listMQuery = $db->getArray("select jo.nom from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='M' order by score{$scTxt} desc limit {$nbM}");
		$listAQuery = $db->getArray("select jo.nom from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='A' order by score{$scTxt} desc limit {$nbA}");
		$effBuffer='';
		foreach($listGQuery as $gardien) {
			$effBuffer .= addslashes($gardien[0]);
			$effBuffer .= ', ';
		}
		$effBuffer = substr($effBuffer,0,-2);
		$effBuffer .= ' - ';
		foreach($listDQuery as $defenseur) {
			$effBuffer .= addslashes($defenseur[0]);
			$effBuffer .= ', ';
		}
		$effBuffer = substr($effBuffer,0,-2);
		$effBuffer .= ' - ';
		foreach($listMQuery as $milieu) {
			$effBuffer .= addslashes($milieu[0]);
			$effBuffer .= ', ';
		}
		$effBuffer = substr($effBuffer,0,-2);
		$effBuffer .= ' - ';
		foreach($listAQuery as $attaquant) {
			$effBuffer .= addslashes($attaquant[0]);
			$effBuffer .= ', ';
		}
		$effBuffer = substr($effBuffer,0,-2);
		return $effBuffer;
	}
	
	$nomTrophee = htmlspecialchars(correctSlash($_POST['nomTrophee']), ENT_COMPAT, 'UTF-8');
	valideString($nomTrophee,'Nom trophee','managePalmares');
	$pouleId = $_POST['poule'];
	$score = intval($_POST['score']);
	
	$scoreTxt = '';
	if ($score > 0) {
		$scoreTxt .= $score;
	}
	$getPalmaresQuery=$db->getArray("select ek.id, ek.nom, ek.score{$scoreTxt}, tac.nb_g, tac.nb_d, tac.nb_m, tac.nb_a from ekyp as ek, tactique as tac where ek.tactique_id=tac.id and ek.complete=1 and ek.poule_id={$pouleId} order by ek.score{$scoreTxt} desc limit 3");
	if ($getPalmaresQuery != NULL) {
		if (sizeof($getPalmaresQuery) == 3) {
			$eff1 = getEffectif($getPalmaresQuery[0][0],$getPalmaresQuery[0][3],$getPalmaresQuery[0][4],$getPalmaresQuery[0][5],$getPalmaresQuery[0][6],$scoreTxt);
			$eff2 = getEffectif($getPalmaresQuery[1][0],$getPalmaresQuery[1][3],$getPalmaresQuery[1][4],$getPalmaresQuery[1][5],$getPalmaresQuery[1][6],$scoreTxt);
			$eff3 = getEffectif($getPalmaresQuery[2][0],$getPalmaresQuery[2][3],$getPalmaresQuery[2][4],$getPalmaresQuery[2][5],$getPalmaresQuery[2][6],$scoreTxt);
			$nom1=addslashes($getPalmaresQuery[0]['nom']);
			$nom2=addslashes($getPalmaresQuery[1]['nom']);
			$nom3=addslashes($getPalmaresQuery[2]['nom']);
			$saveQuery = "insert into palmares(date_enregistrement,trophee,score_premier,nom_premier,effectif_premier,score_deuxieme,nom_deuxieme,effectif_deuxieme,score_troisieme,nom_troisieme,effectif_troisieme) values (now(),'{$nomTrophee}',{$getPalmaresQuery[0][2]},'{$nom1}','{$eff1}',{$getPalmaresQuery[1][2]},'{$nom2}','{$eff2}',{$getPalmaresQuery[2][2]},'{$nom3}','{$eff3}')";
			$db->query($saveQuery) or die('Error, '.mysql_error());
		} else {
			$err = "Nombre de class&eacutes insuffisant";
			header('Location: ../index.php?page=managePalmares&ErrorMsg='.$err);
			exit();
		}
	}
	header('Location: ../index.php?page=palmares');
	exit();
?>