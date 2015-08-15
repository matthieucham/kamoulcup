<div class="sous_titre">Derniers résultats</div>
	<?php
		$listMatchsQuery = "select re.id as matchId, clDom.id as clDomId, clDom.nom as clDomNom, clDom.id_lequipe as clDomEq, clExt.id as clExtId, clExt.nom as clExtNom, clExt.id_lequipe as clExtEq, date_format(jo.date,'%d/%m') as dateJournee, re.buts_club_dom, re.buts_club_ext, jo.numero from rencontre as re, club as clDom, club as clExt, journee as jo where re.club_dom_id = clDom.id and re.club_ext_id = clExt.id and re.journee_id = jo.id and jo.numero=(select max(numero) from journee where date <= now())";
		$resultatsJournee = $db->getArray($listMatchsQuery);
		if ($resultatsJournee != NULL) {
			//echo "<div class='centre'>";
			echo "<p>Journée {$resultatsJournee[0]['numero']} du {$resultatsJournee[0]['dateJournee']}</p>";
			echo "<table class='tableau_horizon' width='100%'>";
			foreach ($resultatsJournee as $resultat) {
				//$domLogo = '<img src=\''.getURLLogoClubSmall($resultat['clDomEq']).'\'/>';
				//$extLogo = '<img src=\''.getURLLogoClubSmall($resultat['clExtEq']).'\'/>';
				echo "<tr><td align='right'><a href='index.php?page=detailClub&clubid={$resultat['clDomId']}'>{$resultat['clDomNom']}</a></td><td align='center'><a href='index.php?page=detailMatch&rencontreid={$resultat['matchId']}'>{$resultat['buts_club_dom']} - {$resultat['buts_club_ext']}</a></td><td align='left'><a href='index.php?page=detailClub&clubid={$resultat['clExtId']}'>{$resultat['clExtNom']}</a></td></tr>";
			}
			echo "</table>";
			//echo "</div>";
		}
	?>
<p>» <a href="index.php?page=tousLesMatchs">Tous les résultats passés</a></p>