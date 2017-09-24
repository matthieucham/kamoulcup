<?php
include_once('process/validateForm.php');
include_once('process/formatStyle.php');
include_once('process/conversion.php');

if (! isset($_GET['rencontreid'])) {
	echo '<p class=\"error\">Pas de rencontreId !</p>';
	exit;
}
$matchId = intval(correctSlash($_GET['rencontreid']));
$matchQ = "select re.id as matchId, clDom.id as clDomId, clDom.nom as clDomNom, clDom.id_lequipe as clDomEq, clExt.id as clExtId, clExt.nom as clExtNom, clExt.id_lequipe as clExtEq, date_format(jo.date,'%d/%m') as dateMatch, re.buts_club_dom, re.buts_club_ext, re.elimination from rencontre as re, club as clDom, club as clExt, journee as jo where re.club_dom_id = clDom.id and re.club_ext_id = clExt.id and re.journee_id = jo.id and re.id={$matchId} limit 1";
$getMatchQuery = $db->getArray($matchQ);

$listPerformancesDomQuery = $db->getArray("select pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e, pr.penalty_obtenu, pr.score, jo.id as joueurId, jo.prenom, jo.nom, pr.minutes, pr.arrets, pr.encaisses, pr.leader, jo.poste, pr.but_marque, pr.passe_dec, pr.penalty_marque, pr.penalty_arrete from prestation as pr, joueur as jo, rencontre as re where re.id='{$matchId}' and re.club_dom_id=jo.club_id and pr.match_id=re.id and pr.joueur_id=jo.id order by field(jo.poste,'G','D','M','A')");
$listPerformancesExtQuery = $db->getArray("select pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e, pr.penalty_obtenu, pr.score, jo.id as joueurId, jo.prenom, jo.nom, pr.minutes, pr.arrets, pr.encaisses, pr.leader, jo.poste, pr.but_marque, pr.passe_dec, pr.penalty_marque, pr.penalty_arrete from prestation as pr, joueur as jo, rencontre as re where re.id='{$matchId}' and re.club_ext_id=jo.club_id and pr.match_id=re.id and pr.joueur_id=jo.id order by field(jo.poste,'G','D','M','A')");

$buteurs = array('dom' => array(array()), 'ext' => array(array()));
$passeurs = array('dom' => array(array()), 'ext' => array(array()));
$penaltys = array('dom' => array(array()), 'ext' => array(array()));
$penaltys_obtenus = array('dom' => array(array()), 'ext' => array(array()));
$penaltys_arretes = array('dom' => array(array()), 'ext' => array(array()));
// Remplissage des tableaux
if ($listPerformancesDomQuery != NULL) {
	foreach ($listPerformancesDomQuery as $perf) {
		if ($perf['but_marque'] > 0) {
			$buteurs['dom'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$buteurs['dom'][$perf['joueurId']]['nb'] = $perf['but_marque'];
		}
		if ($perf['penalty_marque'] > 0) {
			$penaltys['dom'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys['dom'][$perf['joueurId']]['nb'] = $perf['penalty_marque'];
		}
		if ($perf['passe_dec'] > 0) {
			$passeurs['dom'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$passeurs['dom'][$perf['joueurId']]['nb'] = $perf['passe_dec'];
		}
		if ($perf['penalty_obtenu'] > 0) {
			$penaltys_obtenus['dom'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys_obtenus['dom'][$perf['joueurId']]['nb'] = $perf['penalty_obtenu'];
		}
		if ($perf['penalty_arrete'] > 0) {
			$penaltys_arretes['dom'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys_arretes['dom'][$perf['joueurId']]['nb'] = $perf['penalty_arrete'];
		}
	}
}
if ($listPerformancesExtQuery != NULL) {
	foreach ($listPerformancesExtQuery as $perf) {
		if ($perf['but_marque'] > 0) {
			$buteurs['ext'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$buteurs['ext'][$perf['joueurId']]['nb'] = $perf['but_marque'];
		}
		if ($perf['penalty_marque'] > 0) {
			$penaltys['ext'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys['ext'][$perf['joueurId']]['nb'] = $perf['penalty_marque'];
		}
		if ($perf['passe_dec'] > 0) {
			$passeurs['ext'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$passeurs['ext'][$perf['joueurId']]['nb'] = $perf['passe_dec'];
		}
		if ($perf['penalty_obtenu'] > 0) {
			$penaltys_obtenus['ext'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys_obtenus['ext'][$perf['joueurId']]['nb'] = $perf['penalty_obtenu'];
		}
		if ($perf['penalty_arrete'] > 0) {
			$penaltys_arretes['ext'][$perf['joueurId']]['joueur'] = $perf['prenom'].' '.$perf['nom'];
			$penaltys_arretes['ext'][$perf['joueurId']]['nb'] = $perf['penalty_arrete'];
		}
	}
}

$pictoBut = '<img src=\''.picto('BU').'\' title=\'But marqué\'/>';
$pictoPasse = '<img src=\''.picto('PD').'\' title=\'Passe décisive\'/>';
$pictoPenalty = '<img src=\''.picto('PE').'\' title=\'Penalty marqué\'/>';
$pictoPenoObt = '<img src=\''.picto('PO').'\' title=\'Penalty obtenu\'/>';
$pictoPenoStop = '<img src=\''.picto('PEST').'\' title=\'Penalty arrêté\'/>';

?>

<div class="titre_page">Compte-rendu de match</div>
<div class='section_page'>
<div id="matchSummary"><?php
echo $getMatchQuery[0]['dateMatch'].'<br/>';
if ($getMatchQuery[0]['elimination'] > 0) {
	echo "Match à élimination directe";
}
echo "<table class='tableau_horizon_match' width='100%'>";
echo "<tr><th align='right' width='41%'><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clDomId']}'>{$getMatchQuery[0]['clDomNom']}</a></th><th align='center' width='6%'>-</th><th align='left' width='41%'><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clExtId']}'>{$getMatchQuery[0]['clExtNom']}</a></th></tr>";
echo "<tr><th align='right'>{$getMatchQuery[0]['buts_club_dom']}</th><th></th><th align='left'>{$getMatchQuery[0]['buts_club_ext']}</th></tr>";
echo "<tr><td align='right'>";
if (count($buteurs['dom'])>1) {
	echo "<p>{$pictoBut} <b>Buts</b></p>";
	foreach ($buteurs['dom'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys['dom'])>1) {
	echo "<p>{$pictoPenalty} <b>Pénaltys</b></p>";
	foreach ($penaltys['dom'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($passeurs['dom']) > 1){
	echo "<p>{$pictoPasse} <b>Passes décisives</b></p>";
	foreach ($passeurs['dom'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys_obtenus['dom'])>1) {
	echo "<p>{$pictoPenoObt} <b>Pénaltys obtenus</b></p>";
	foreach ($penaltys_obtenus['dom'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys_arretes['dom'])>1) {
	echo "<p>{$pictoPenoStop} <b>Pénaltys arrêtés</b></p>";
	foreach ($penaltys_arretes['dom'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
echo "</td>";
echo "<td></td><td align='left'>";
if (count($buteurs['ext'])>1) {
	echo "<p>{$pictoBut} <b>Buts</b></p>";
	foreach ($buteurs['ext'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys['ext'])>1) {
	echo "<p>{$pictoPenalty} <b>Pénaltys</b></p>";
	foreach ($penaltys['ext'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($passeurs['ext']) > 1){
	echo "<p>{$pictoPasse} <b>Passes décisives</b></p>";
	foreach ($passeurs['ext'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys_obtenus['ext'])>1) {
	echo "<p>{$pictoPenoObt} <b>Pénaltys obtenus</b></p>";
	foreach ($penaltys_obtenus['ext'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
if (count($penaltys_arretes['ext'])>1) {
	echo "<p>{$pictoPenoStop} <b>Pénaltys arrêtés</b></p>";
	foreach ($penaltys_arretes['ext'] as $jid=>$but) {
		echo "<p><a href='index.php?page=detailJoueur&joueurid={$jid}'>{$but['joueur']}";
		if ($but['nb']> 1) {
			echo " x{$but['nb']}";
		}
		echo "</a></p>";
	}
}
echo "</td></tr>";
echo "</table>";
?></div>
</div>


<div class="sous_titre">Performances</div>
<div class='section_page'>
<div class="colgauche_container">
<div id="perfDomicile"><?php
echo "<b><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clDomId']}'>{$getMatchQuery[0]['clDomNom']}</a></b>";
if ($listPerformancesDomQuery != NULL) {
	echo "<table class='tableau_liste_centre'>";
	echo "<tr><th>Joueur</th><th>Tps</th><th title='Orange Sports'>OS</th><th title='Whoscored'>WS</th><th title='Sports.fr'>SP</th>";
	//<th title='http://www.datasport.it/europei_2012/'>DS</th>";
	/*<th title='Pas utilisé'>-</th>*/
	echo "<th title='Arrêts ou parades (Gardien seulement)'>Arr.</th><th title='Buts encaissés (Gardien seulement)'>Enc.</th>";
	echo"</tr>";
	$cptLigne=0;
	foreach ($listPerformancesDomQuery as $perf) {
		$classNum = $cptLigne % 2;
		$highlight= ($perf['leader'] == 1);
		echo "<tr class='ligne{$classNum}'><td style={text-align:left;}>";
		if ($highlight) {
			echo "<b>";
		}
		echo "<a href='index.php?page=detailJoueur&joueurid={$perf['joueurId']}'>{$perf['prenom']} {$perf['nom']}</a>";
		if ($highlight) {
			echo "</b>";
		}
		$noteWS = $perf['note_ff'];
		$noteWSConv = convertNoteWS($noteWS);
		$showNoteWS = $noteWSConv.'<span class="miniNote">&nbsp;['.$noteWS.']</span>';
		$noteEQ = formatNote($perf['note_lequipe']);
		$noteSP = formatNote($perf['note_sp']);
		echo "</td><td>{$perf['minutes']}'</td><td>{$noteEQ}</td><td>{$showNoteWS}</td><td>{$noteSP}</td>";
		//<td>{$perf['note_d']}</td>";
		/*<td>{$perf['note_e']}</td>"*/;
		if ($perf['poste'] == 'G') {
			echo "<td>{$perf['arrets']}</td><td>{$perf['encaisses']}</td>";
		} else {
			echo "<td colspan='2'></td>";
		}
		echo "</tr>";
		$cptLigne++;
	}
	echo "</table>";
}
?></div>
<div id="perfExterieur"><?php
echo "<b><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clExtId']}'>{$getMatchQuery[0]['clExtNom']}</a></b>";
if ($listPerformancesExtQuery != NULL) {
	echo "<table class='tableau_liste_centre'>";
	echo "<tr><th>Joueur</th><th>Tps</th><th title='Orange Sports'>OS</th><th title='Whoscored'>WS</th><th title='Sports.fr'>SP</th>";
	//<th title='http://www.datasport.it/europei_2012/'>DS</th>";
	/*<th title='Pas utilisé'>-</th>*/
	echo "<th title='Arrêts ou parades (Gardien seulement)'>Arr.</th><th title='Buts encaissés (Gardien seulement)'>Enc.</th>";
	echo"</tr>";
	$cptLigne=0;
	foreach ($listPerformancesExtQuery as $perf) {
		$classNum = $cptLigne % 2;
		$highlight= ($perf['leader'] == 1);
		echo "<tr class='ligne{$classNum}'><td style={text-align:left;}>";
		if ($highlight) {
			echo "<b>";
		}
		echo "<a href='index.php?page=detailJoueur&joueurid={$perf['joueurId']}'>{$perf['prenom']} {$perf['nom']}</a>";
		if ($highlight) {
			echo "</b>";
		}
		$noteWS = $perf['note_ff'];
		$noteWSConv = convertNoteWS($noteWS);
		$showNoteWS = $noteWSConv.'<span class="miniNote">&nbsp;['.$noteWS.']</span>';
		$noteEQ = formatNote($perf['note_lequipe']);
		$noteSP = formatNote($perf['note_sp']);
		echo "</td><td>{$perf['minutes']}'</td><td>{$noteEQ}</td><td>{$showNoteWS}</td><td>{$noteSP}</td>";
		//<td>{$perf['note_d']}</td>";
		/*<td>{$perf['note_e']}</td>"*/;
		if ($perf['poste'] == 'G') {
			echo "<td>{$perf['arrets']}</td><td>{$perf['encaisses']}</td>";
		} else {
			echo "<td colspan='2'></td>";
		}
		echo "</tr>";
		$cptLigne++;
	}
	echo "</table>";
}
?></div>
</div>
</div>

