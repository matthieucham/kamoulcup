<?php
include_once('process/validateForm.php');
include_once('process/formatStyle.php');
include_once('process/utils.php');
?>
<div class="sous_titre">Tous les résultats</div>
<?php
$listMatchsQuery = "select re.id as matchId, clDom.id as clDomId, clDom.nom as clDomNom, clDom.id_lequipe as clDomEq, clExt.id as clExtId, clExt.nom as clExtNom, clExt.id_lequipe as clExtEq, date_format(jo.date,'%d/%m') as dateJournee, re.buts_club_dom, re.buts_club_ext, jo.numero, jo.id as idJournee from rencontre as re, club as clDom, club as clExt, journee as jo where re.club_dom_id = clDom.id and re.club_ext_id = clExt.id and re.journee_id = jo.id order by jo.date asc, re.id asc";
$resultats = $db->getArray($listMatchsQuery);
if ($resultats != NULL) {
	//echo "<div class='centre'>";
	$currentJourneeId = -1;
	foreach ($resultats as $resultat) {
		if ($currentJourneeId != $resultat['idJournee'])
		{
			if ($currentJourneeId >= 0) {
				echo "</table>";
				echo "</div>";
			}
			echo "<div class='sectionPage'>";
			echo "<p>Journée {$resultat['numero']} du {$resultat['dateJournee']}</p>";
			echo "<table class='tableau_horizon' width='100%'>";
		}
		$currentJourneeId = $resultat['idJournee'];
		//$domLogo = '<img src=\''.getURLLogoClubSmall($resultat['clDomEq']).'\'/>';
		//$extLogo = '<img src=\''.getURLLogoClubSmall($resultat['clExtEq']).'\'/>';
		echo "<tr><td align='right'><a href='index.php?page=detailClub&clubid={$resultat['clDomId']}'>{$resultat['clDomNom']}</a></td><td align='center'><a href='index.php?page=detailMatch&rencontreid={$resultat['matchId']}'>{$resultat['buts_club_dom']} - {$resultat['buts_club_ext']}</a></td><td align='left'><a href='index.php?page=detailClub&clubid={$resultat['clExtId']}'>{$resultat['clExtNom']}</a></td></tr>";
	}
	//echo "</div>";
	if ($currentJourneeId >= 0) {
		echo "</table>";
		echo "</div>";
	}
}
?>
