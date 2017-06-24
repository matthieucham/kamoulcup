<?php
include('process/reventeJoueur.php');
include('process/params/notationParams.php');
include('process/validateForm.php');
include('process/formatStyle.php');
if (! isset($_GET['joueurid'])) {
	echo '<p class=\"error\">Pas de joueurId !</p>';
	exit;
}
$joueurId = correctSlash($_GET['joueurid']);

$getJoueurQuery = $db->getArray("select jo.nom as nomJoueur,jo.prenom,jo.poste,jo.id_lequipe as idJoueur,jo.score,jo.score1,jo.score2 from joueur as jo where jo.id='{$joueurId}' limit 1");
$getClubQuery = $db->getArray("select cl.id, cl.nom, cl.id_lequipe from club as cl, joueur as jo where jo.club_id = cl.id and jo.id='{$joueurId}' limit 1");

$listPerfBonusQuery = $db->getArray("select sum(pr.but_marque) as nbButs, sum(pr.passe_dec) as nbPasses, sum(pr.penalty_marque) as nbPenaltys, sum(pr.penalty_obtenu) as nbPenObtenus, sum(pr.defense_vierge) as nbDefVierge, sum(pr.defense_unpenalty) as nbDefPeno, sum(pr.defense_unbut) as nbDefUnBut, sum(pr.troisbuts) as nbTroisButs, sum(pr.troisbuts_unpenalty) as nbTroisButsPeno, sum(pr.leader) as nbLeader, sum(pr.penalty_arrete) as nbPenoStop from prestation as pr where pr.joueur_id='{$joueurId}'");
$listPerformancesQuery = $db->getArray("select pr.score,pr.but_marque,pr.passe_dec,pr.penalty_marque,pr.penalty_obtenu,pr.defense_vierge,pr.defense_unpenalty, clDom.id as clubDomId, clDom.nom as clubDom, clDom.id_lequipe as idDom, clExt.id as clubExtId, clExt.nom as clubExt, clExt.id_lequipe as idExt, re.buts_club_dom, re.buts_club_ext, re.id as rencontreId,pr.score,date_format(jo.date,'%d/%m') as dateMatch, pr.minutes, re.elimination,pr.defense_unbut,pr.troisbuts,pr.troisbuts_unpenalty,pr.leader,pr.arrets,pr.penalty_arrete from prestation as pr, rencontre as re, club as clDom, club as clExt,journee as jo where pr.joueur_id='{$joueurId}' and pr.match_id=re.id and re.club_dom_id=clDom.id and re.club_ext_id=clExt.id and re.journee_id=jo.id order by jo.date asc");
$listTransfertsQuery = $db->getArray("select po.nom as nomPoule, ek.id, ek.nom as nomEkyp, date_format(tr.transfert_date,'%d/%m') as trdate, tr.anciennete, tr.prix_achat, tr.coeff_bonus_achat, tr.draft, tr.choix_draft from transfert as tr,poule as po, ekyp as ek where tr.joueur_id={$joueurId} and tr.poule_id=po.id and tr.ekyp_id=ek.id");
$extraBonusQuery = $db->getArray("select sum(valeur) as total from bonus_joueur where joueur_id={$joueurId}");

$notesQuery = $db->getArray("select count(id), avg(score) from prestation where joueur_id={$joueurId} and minutes>={$SCO_minTps} and score>0 limit {$SCO_nbperfs}");
$entreesCourtesQuery = $db->getArray("select count(id) from prestation where joueur_id={$joueurId} and minutes<{$SCO_tpsEntreeCourte} limit {$SCO_nbperfs}");
$entreesLonguesQuery = $db->getArray("select count(id) from prestation where joueur_id={$joueurId} and ( (minutes>={$SCO_tpsEntreeCourte} and (minutes<{$SCO_minTps}) ) or ((minutes>={$SCO_minTps}) and score=0) ) limit {$SCO_nbperfs}");

$monJoueur = false;
if (isset($_SESSION['myEkypId'])) {
	$monJoueurQuery = $db->getArray("select prix_achat from transfert where joueur_id='{$joueurId}' and ekyp_id='{$_SESSION['myEkypId']}' limit 1");
	$monJoueur = ($monJoueurQuery != NULL);
}
$pictoBut = '<img src=\''.picto('BU').'\' title=\'But marqué\'/>';
$pictoPasse = '<img src=\''.picto('PD').'\' title=\'Passe décisive\'/>';
$pictoPenalty = '<img src=\''.picto('PE').'\' title=\'Penalty marqué\'/>';
$pictoPenoObt = '<img src=\''.picto('PO').'\' title=\'Penalty obtenu\'/>';
$pictoBonusDef = '<img src=\''.picto('BD').'\' title=\'Pas de but encaissé\'/>';
$pictoDemiBonus = '<img src=\''.picto('BP').'\' title=\'Un seul but encaissé sur pen. ou en prolong.\'/>';
$pictoBonusEx = '<img src=\''.picto('BE').'\' title=\'Bonus exceptionnel\'/>';
$pictoUnBut = '<img src=\''.picto('BJ').'\' title=\'Un seul but encaissé, dans le jeu\'/>';
$pictoBonusOff = '<img src=\''.picto('3B').'\' title=\'3 buts marqués (dans le jeu) ou plus \'/>';
$pictoDemiBonusOff = '<img src=\''.picto('3BP').'\' title=\'3 buts marqués dont un seul pénalty\'/>';
$pictoTroisArrets = '<img src=\''.picto('3ST').'\' title=\'Plus de 3 arrêts\'/>';
$pictoPenoStop = '<img src=\''.picto('PEST').'\' title=\'Pénalty arrêté\'/>';
?>

<div class="titre_page"><?php echo "{$getJoueurQuery[0]['prenom']} {$getJoueurQuery[0]['nomJoueur']}"; ?>
</div>

<div class="colgauche_container">
<div class="colgauche_gauche"><?php
//echo '<img src="'.getURLPhotoJoueur($getJoueurQuery[0]['idJoueur']).'" alt="photo '.$getJoueurQuery[0]['nomJoueur'].'"/><br/>';
echo "{$getJoueurQuery[0]['prenom']} {$getJoueurQuery[0]['nomJoueur']}<br/>";
echo traduire($getJoueurQuery[0]['poste']).'<br/>';
if ($getClubQuery != NULL) {
	echo '<a href=\'index.php?page=detailClub&clubid='.$getClubQuery[0]['id'].'\'>'.$getClubQuery[0]['nom'].'</a><br/>';
	//echo '<img src="'.getURLLogoClub($getClubQuery[0]['id_lequipe']).'" alt="Logo '.$getClubQuery[0]['nom'].'"/>';
}
if ($monJoueur) {
	// Aff de la partie spécifique à ses propres joueurs
	echo "<div class='myPlayerCadre'>";

	if (isReventeForceMajeure($db,$joueurId)) {
		$prixVente = round($monJoueurQuery[0]['prix_achat']*$EKY_rachatForceMajeure,1);
	} else {
		$prixVente = round($monJoueurQuery[0]['prix_achat']*$EKY_rachatBA,1);
	}

	if (isReventeEnCours($db,$_SESSION['pouleId'],$joueurId)){
		echo "<p>Vous avez demandé la revente de ce joueur. Elle sera effective avant la prochaine résolution, vous pouvez déjà compter sur une somme supplémentaire de <b>{$prixVente} Ka</b> pour enchérir sur d'autres joueurs.</p>";
	}

	if (isReventeBaPossible($db,$_SESSION['myEkypId'],$joueurId) && (! isVenteEnCours($db,$_SESSION['pouleId'],$joueurId))) {

		echo "<br/><form method='POST' action='index.php'>";
		echo "<input type='hidden' name='page' value='postRevente'/>";
		echo "<input type='hidden' name='joueurId' value='{$joueurId}'/>";
		echo "<input type='hidden' name='prenom' value='{$getJoueurQuery[0]['prenom']}'/>";
		echo "<input type='hidden' name='nom' value='{$getJoueurQuery[0]['nomJoueur']}'/>";
		echo "<input type='hidden' name='type' value='RE'/>";
		echo "<input type='hidden' name='montant' value='{$prixVente}'/>";
		echo "Prix de rachat BA:<br/>{$prixVente} Ka<br/>";
		echo "<input type='submit' value='Revente BA'/>";
		echo "</form><br/>";
	}
	if (isMVPossible($db,$_SESSION['myEkypId']) && (! isVenteEnCours($db,$_SESSION['pouleId'],$joueurId))) {
		echo "<b>» <a href='index.php?page=vendreJoueur&joueurId={$joueurId}'>Mettre en vente</a></b>";
	}
	echo "</div>";
}
?></div>
<div class="colgauche_droite">
<div class="sectionPage"><?php
//echo '<p>» <a href="'.getURLFicheJoueur($getJoueurQuery[0]['idJoueur']).'">Consulter sa fiche sur lequipe.fr</a></p><br/>';
?>
<div class="sous_titre">Transferts</div>
<?php

if ($listTransfertsQuery == NULL) {
	echo "Joueur libre";
	$isJoueurLibre=true;
} else {
	$isJoueurLibre=false;
	echo "<table class='tableau_liste'>";
	echo "<tr><th>Poule</th><th>Appartient à</th><th>Depuis le</th><th>Prix d'achat</th><th>Bonification</th></tr>";
	$cptLigne = 0;
	foreach ($listTransfertsQuery as $transfert) {
		$classNum = $cptLigne % 2;
		$coeffBonif = round(floatval($transfert['coeff_bonus_achat']),2);
		if ($coeffBonif != 1.0) {
			$scoreInit = floatval($getJoueurQuery[0]['score']);
			$scoreBonif = $scoreInit*$coeffBonif;
			$bonif = '<b>+'.(number_format(round($scoreBonif-$scoreInit,2),2)).'</b>';
		} else {
			$bonif = '-';
		}
		$prix = $transfert['prix_achat'].' Ka';
		if (intval($transfert['draft']) > 0) {
			$prix = '<b>drafté</b> (Tour '.$transfert['choix_draft'].')';
		}
		echo "<tr class='ligne{$classNum}'><td>{$transfert['nomPoule']}</td><td><a href='index.php?page=showEkyp&ekypid={$transfert['id']}'>{$transfert['nomEkyp']}</a></td><td>{$transfert['trdate']}</td><td>{$prix}</td><td>{$bonif}</td></tr>";
		$cptLigne++;
	}
	echo "</table>";
}
?></div>

<div class="sous_titre">Notes</div>
<table class='tableau_horizon'>
<?php
$noteMoyenne=number_format(round(floatval($notesQuery[0][1]),2),2);
echo "<tr><th>Note moyenne</th><td width='50px' align='right'> {$noteMoyenne}</td></tr>";
echo "<tr><th>Entrées en jeu de plus de 15 min</th><td width='50px' align='right'>{$entreesLonguesQuery[0][0]}</td></tr>";
echo "<tr><th>Entrées en jeu de moins de 15 min</th><td width='50px' align='right'>{$entreesCourtesQuery[0][0]}</td></tr>";
echo "<tr class='ligne_bilan'><th>Nombre de matchs notés</th><td width='50px' align='right'>{$notesQuery[0][0]}</td></tr>";
?>
</table>

<div class="sous_titre">Bonus / Malus</div>
<?php
echo "<table class='tableau_horizon'>";
if (($getJoueurQuery[0]['poste'] == 'D') || ($getJoueurQuery[0]['poste'] == 'M')) {
	echo "<tr><th>Meilleur de son club à son poste</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbLeader']}</td></tr>";
}
echo "<tr><th>{$pictoBut} Buts marqués (hors pénaltys)</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbButs']}</td></tr>";
echo "<tr><th>{$pictoPasse} Passes décisives</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbPasses']}</td></tr>";
echo "<tr><th>{$pictoPenalty} Pénaltys marqués</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbPenaltys']}</td></tr>";
echo "<tr><th>{$pictoPenoObt} Pénaltys obtenus</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbPenObtenus']}</td></tr>";
if ($getJoueurQuery[0]['poste'] == 'G') {
	echo "<tr><th>{$pictoPenoStop} Pénaltys arrêtés</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbPenoStop']}</td></tr>";
}
if ($getJoueurQuery[0]['poste'] != 'A') {
	echo "<tr><th>{$pictoBonusDef} Matchs sans buts encaissés</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbDefVierge']}</td></tr>";
	echo "<tr><th>{$pictoDemiBonus} Matchs avec un seul but encaissé sur pénalty</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbDefPeno']}</td></tr>";
}
if ($getJoueurQuery[0]['poste'] == 'A' ||  $getJoueurQuery[0]['poste'] == 'M') {
	echo "<tr><th>{$pictoBonusOff} Matchs 3 buts marqués (dans le jeu) ou plus</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbTroisButs']}</td></tr>";
	echo "<tr><th>{$pictoDemiBonusOff} Matchs avec exactement 3 buts marqués dont un pénalty</th><td width='50px' align='right'>{$listPerfBonusQuery[0]['nbTroisButsPeno']}</td></tr>";
}
echo "<tr><th>{$pictoBonusEx} Total des bonus exceptionnels</th><td width='50px' align='right'>{$extraBonusQuery[0]['total']}</td></tr>";
if ($isJoueurLibre) {
	$scoreFl='?';
	$scoreFl1='?';
	$scoreFl2='?';
} else {
	$scoreFl = number_format(round(floatval($getJoueurQuery[0]['score']),2),2);
	$scoreFl1 = number_format(round(floatval($getJoueurQuery[0]['score1']),2),2);
	$scoreFl2 = number_format(round(floatval($getJoueurQuery[0]['score2']),2),2);
}
echo "<tr class='ligne_bilan'><th>Score du joueur</th><td width='50px' align='right'>{$scoreFl}</td></tr>";
echo "<tr class='ligne_bilan'><th>Score Apertura</th><td width='50px' align='right'>{$scoreFl1}</td></tr>";
echo "<tr class='ligne_bilan'><th>Score Clausura</th><td width='50px' align='right'>{$scoreFl2}</td></tr>";
echo "</table>";
if (! $isJoueurLibre){
	include('div/joueurProgressionDiv.php');
}
?>
<div class="sectionPage">
<div class="sous_titre">Matchs disputés</div>
<table class='tableau_liste_centre'>
	<tr>
		<th>Date</th>
		<th>Match</th>
		<th>Résultat</th>
		<th>Durée</th>
		<th>Note</th>
		<th>Bonus</th>
	</tr>
	<?php
	if ($listPerformancesQuery != NULL) {
		$cptLigne = 0;
		foreach ($listPerformancesQuery as $perf) {
			$classNum = $cptLigne % 2;
			$noteMoy = round($perf['score'],2);
			$minutes = intval($perf['minutes']);
			if ($noteMoy == 0 ||$minutes < 30) {
				$noteMoy = '-';
			}
			$star='';
			if ($perf['elimination']){
				$star=' *';
			}
			$leader='';
			if ($perf['leader']){
				$leader='++';
			}
			$bonus= '';
			$nbBut = $perf['but_marque'];
			if ($nbBut > 0) {
				$bonus .= $pictoBut;
				if ($nbBut > 1) {
					$bonus .= 'x'.$nbBut;
				}
				$bonus .= ' ';
			}
			$nbPasses = $perf['passe_dec'];
			if ($nbPasses > 0) {
				$bonus .= $pictoPasse;
				if ($nbPasses > 1) {
					$bonus .= 'x'.$nbPasses;
				}
				$bonus .= ' ';
			}
			$nbPenalty = $perf['penalty_marque'];
			if ($nbPenalty > 0) {
				$bonus .= $pictoPenalty;
				if ($nbPenalty > 1) {
					$bonus .= 'x'.$nbPenalty;
				}
				$bonus .= ' ';
			}
			$nbPenoObt = $perf['penalty_obtenu'];
			if ($nbPenoObt > 0) {
				$bonus .= $pictoPenoObt;
				if ($nbPenoObt > 1) {
					$bonus .= 'x'.$nbPenoObt;
				}
				$bonus .= ' ';
			}
			if ($getJoueurQuery[0]['poste'] == 'G') {
				$arrets = $perf['arrets'];
				if ($arrets > 3) {
					$bonus .= $pictoTroisArrets;
					$bonus .= ' ';
				}
				$penoStop = $perf['penalty_arrete'];
				if ($penoStop > 0) {
					$bonus .= $pictoPenoStop;
					if ($penoStop > 1) {
						$bonus .= 'x'.$penoStop;
					}
					$bonus .= ' ';
				}
			}
			if ($getJoueurQuery[0]['poste'] != 'A') {
				$bonusDef = $perf['defense_vierge'];
				if ($bonusDef > 0) {
					$bonus .= $pictoBonusDef;
					$bonus .= ' ';
				}
				$bonusPeno = $perf['defense_unpenalty'];
				if ($bonusPeno > 0) {
					$bonus .= $pictoDemiBonus;
				}
			}
			if ($getJoueurQuery[0]['poste'] == 'A' || $getJoueurQuery[0]['poste'] == 'M') {
				$bonusOff = $perf['troisbuts'];
				if ($bonusOff > 0) {
					$bonus .= $pictoBonusOff;
				}
				$bonusOffPeno = $perf['troisbuts_unpenalty'];
				if ($bonusOffPeno > 0) {
					$bonus .= $pictoDemiBonusOff;
				}
			}
			echo "<tr class='ligne{$classNum}'><td>{$perf['dateMatch']}</td><td><a href='index.php?page=detailClub&clubid={$perf['clubDomId']}'>{$perf['clubDom']}</a> - <a href='index.php?page=detailClub&clubid={$perf['clubExtId']}'>{$perf['clubExt']}</a></td><td><a href='index.php?page=detailMatch&rencontreid={$perf['rencontreId']}'>{$perf['buts_club_dom']}-{$perf['buts_club_ext']}{$star}</a></td><td>{$perf['minutes']} '</td><td>{$noteMoy}{$leader}</td><td>{$bonus}</td></tr>";
			$cptLigne++;
		}
	}
	?>
</table>
</div>

</div>
</div>
	<?php
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
	?>