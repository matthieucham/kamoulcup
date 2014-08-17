<?php
	include('process/validateForm.php');
	include('process/formatStyle.php');

	if (! isset($_GET['rencontreid'])) {
		echo '<p class=\"error\">Pas de rencontreId !</p>';
		exit;
	}
	$matchId = intval(correctSlash($_GET['rencontreid']));
	$matchQ = "select re.id as matchId, clDom.id as clDomId, clDom.nom as clDomNom, clDom.id_lequipe as clDomEq, clExt.id as clExtId, clExt.nom as clExtNom, clExt.id_lequipe as clExtEq, date_format(jo.date,'%d/%m') as dateMatch, re.buts_club_dom, re.buts_club_ext, re.elimination from rencontre as re, club as clDom, club as clExt, journee as jo where re.club_dom_id = clDom.id and re.club_ext_id = clExt.id and re.journee_id = jo.id and re.id={$matchId} limit 1";
	$getMatchQuery = $db->getArray($matchQ);
	
	$listPerformancesDomQuery = $db->getArray("select pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e, pr.penalty_obtenu, pr.score, jo.id as joueurId, jo.prenom, jo.nom, pr.minutes, pr.arrets, pr.encaisses, pr.leader, jo.poste from prestation as pr, joueur as jo, rencontre as re where re.id='{$matchId}' and re.club_dom_id=jo.club_id and pr.match_id=re.id and pr.joueur_id=jo.id order by field(jo.poste,'G','D','M','A')");
	$listPerformancesExtQuery = $db->getArray("select pr.note_lequipe,pr.note_ff, pr.note_sp,pr.note_d,pr.note_e, pr.penalty_obtenu, pr.score, jo.id as joueurId, jo.prenom, jo.nom, pr.minutes, pr.arrets, pr.encaisses, pr.leader, jo.poste from prestation as pr, joueur as jo, rencontre as re where re.id='{$matchId}' and re.club_ext_id=jo.club_id and pr.match_id=re.id and pr.joueur_id=jo.id order by field(jo.poste,'G','D','M','A')");
	
	$listButeursDomQuery = $db->getArray("select bu.buteur_id, bu.passeur_id, bu.penalty, bu.prolongation from buteurs as bu where rencontre_id={$matchId} and dom_ext='DOM'");
	$listButeursExtQuery = $db->getArray("select bu.buteur_id, bu.passeur_id, bu.penalty, bu.prolongation from buteurs as bu where rencontre_id={$matchId} and dom_ext='EXT'");
?>

<div class="titre_page">Compte-rendu de match</div>
<div class='section_page'>
<div id="matchSummary">
<?php
	$logoDom = getURLLogoClubSmall($getMatchQuery[0]['clDomEq']);
	$logoExt = getURLLogoClubSmall($getMatchQuery[0]['clExtEq']);
	$domLogo = '<img src=\''.$logoDom.'\'/>';
	$extLogo = '<img src=\''.$logoExt.'\'/>';
	echo $getMatchQuery[0]['dateMatch'].'<br/>';
	if ($getMatchQuery[0]['elimination'] > 0) {
		echo "Match à élimination directe";
	}
	echo "<table class='tableau_horizon_match' width='100%'>";
	echo "<tr><th width='6%'>{$domLogo}</th><th align='right' width='41%'><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clDomId']}'>{$getMatchQuery[0]['clDomNom']}</a></th><th align='center' width='6%'>-</th><th align='left' width='41%'><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clExtId']}'>{$getMatchQuery[0]['clExtNom']}</a></th><th width='6%'>{$extLogo}</th></tr>";
	echo "<tr><th></th><th align='right'>{$getMatchQuery[0]['buts_club_dom']}</th><th></th><th align='left'>{$getMatchQuery[0]['buts_club_ext']}</th><th></th></tr>";
	echo "<tr><td></td><td align='right'>";
	if ($listButeursDomQuery != NULL)
	{
	foreach($listButeursDomQuery as $but) {
		if ($but['buteur_id'] > 0) {
			$getJoueur = $db->getArray("select prenom,nom from joueur where id={$but['buteur_id']} limit 1");
			echo "<a href='index.php?page=detailJoueur&joueurid={$but['buteur_id']}'>{$getJoueur[0]['prenom']} {$getJoueur[0]['nom']}</a>";
		} else {
			echo "c.s.c.";
		}
		if ($but['penalty'] > 0) {
			echo " sur pen.";
		}
		if ($but['passeur_id'] > 0) {
			$getJoueur = $db->getArray("select prenom,nom from joueur where id={$but['passeur_id']} limit 1");
			echo " (<a href='index.php?page=detailJoueur&joueurid={$but['passeur_id']}'>{$getJoueur[0]['prenom']} {$getJoueur[0]['nom']}</a>)";
		}
		if ($but['prolongation'] > 0) {
			echo " en prolong.";
		}
		echo "<br/>";
	}
	}
	echo "</td>";
	echo "<td></td><td align='left'>";
	if ($listButeursExtQuery != NULL)
	{
	foreach($listButeursExtQuery as $but) {
		if ($but['buteur_id'] > 0) {
			$getJoueur = $db->getArray("select prenom,nom from joueur where id={$but['buteur_id']} limit 1");
			echo "<a href='index.php?page=detailJoueur&joueurid={$but['buteur_id']}'>{$getJoueur[0]['prenom']} {$getJoueur[0]['nom']}</a>";
		} else {
			echo "c.s.c.";
		}
		if ($but['penalty'] > 0) {
			echo " sur pen.";
		}
		if ($but['passeur_id'] > 0) {
			$getJoueur = $db->getArray("select prenom,nom from joueur where id={$but['passeur_id']} limit 1");
			echo " (<a href='index.php?page=detailJoueur&joueurid={$but['buteur_id']}'>{$getJoueur[0]['prenom']} {$getJoueur[0]['nom']}</a>)";
		}
		if ($but['prolongation'] > 0) {
			echo " en prolong.";
		}
		echo "<br/>";
	}
	}
	echo "</td><td></td></tr>";
	echo "</table>";
?>
</div>
</div>


<div class="sous_titre">Performances</div>
<div class='section_page'>
<div class="colgauche_container">
	<div id="perfDomicile">
		<?php
		echo "<b><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clDomId']}'>{$getMatchQuery[0]['clDomNom']}</a></b>";
		if ($listPerformancesDomQuery != NULL) {
			echo "<table class='tableau_liste_centre'>";
			echo "<tr><th>Joueur</th><th>Tps</th><th title='http://www.lequipe.fr/'>L'Eq</th><th title='http://www.whoscored.com/'>WS</th><th title='?'>?</th>";
			//<th title='http://www.datasport.it/europei_2012/'>DS</th>";
			/*<th title='Pas utilisé'>-</th>*/
			echo "<th title='Penalty obtenu mais non marqué'>p.o.<br/>n.m.</th>";
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
				echo "</td><td>{$perf['minutes']}'</td><td>{$perf['note_lequipe']}</td><td>{$perf['note_ff']}</td><td>{$perf['note_sp']}</td>";
				//<td>{$perf['note_d']}</td>";
				/*<td>{$perf['note_e']}</td>"*/;
				$penoObt = intval($perf['penalty_obtenu']);
				if ($penoObt > 0) {
					$transformesQuery=$db->getArray("select count(id) from buteurs where rencontre_id={$matchId} and penalty=1 and passeur_id={$perf['joueurId']}");
					$penoObt -= $transformesQuery[0][0];
				}
				if ($penoObt > 0) {
					echo "<td><b>+{$penoObt}</b></td></tr>";
				 } else {
					echo "<td>-</td>";
				 }
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
		?>
	</div>
	<div id="perfExterieur">
		<?php
		echo "<b><a href='index.php?page=detailClub&clubid={$getMatchQuery[0]['clExtId']}'>{$getMatchQuery[0]['clExtNom']}</a></b>";
		if ($listPerformancesExtQuery != NULL) {
			echo "<table class='tableau_liste_centre'>";
			echo "<tr><th>Joueur</th><th>Tps</th><th title='http://www.lequipe.fr/'>L'Eq</th><th title='http://www.whoscored.com/'>WS</th><th title='?'>?</th>";
			//<th title='http://www.datasport.it/europei_2012/'>DS</th>";
			/*<th title='Pas utilisé'>-</th>*/
			echo "<th title='Penalty obtenu mais non marqué'>p.o.<br/>n.m.</th>";
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
				echo "</td><td>{$perf['minutes']}'</td><td>{$perf['note_lequipe']}</td><td>{$perf['note_ff']}</td><td>{$perf['note_sp']}</td>";
				//<td>{$perf['note_d']}</td>";
				/*<td>{$perf['note_e']}</td>"*/;
				$penoObt = intval($perf['penalty_obtenu']);
				if ($penoObt > 0) {
					$transformesQuery=$db->getArray("select count(id) from buteurs where rencontre_id={$matchId} and penalty=1 and passeur_id={$perf['joueurId']}");
					$penoObt -= $transformesQuery[0][0];
				}
				if ($penoObt > 0) {
					echo "<td><b>+{$penoObt}</b></td></tr>";
				 } else {
					echo "<td>-</td>";
				 }
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
		?>
	</div>
</div>
</div>

