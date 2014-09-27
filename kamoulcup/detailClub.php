<?php
	include_once('process/validateForm.php');
	include_once('process/formatStyle.php');
	include_once('process/utils.php');
	
	
	if (! isset($_GET['clubid'])) {
		echo '<p class=\"error\">Pas de clubId !</p>';
		exit;
	}
	$clubId = correctSlash($_GET['clubid']);
	$getClubQuery = $db->getArray("select nom,id_lequipe from club where id='{$clubId}' limit 1");
	$matchQ = "select re.id as matchId, clDom.id as clDomId, clDom.nom as clDomNom,clExt.id as clExtId, clExt.nom as clExtNom,date_format(jo.date,'%d/%m') as dateMatch, re.buts_club_dom, re.buts_club_ext from rencontre as re, club as clDom, club as clExt, journee as jo where re.club_dom_id = clDom.id and re.club_ext_id = clExt.id and re.journee_id = jo.id and (re.club_dom_id='{$clubId}' or re.club_ext_id='{$clubId}') order by jo.date asc";
	$listMatchsQuery = $db->getArray($matchQ);
	$listJoueursQuery = $db->getArray("select jo.id,jo.nom as nomJoueur,jo.prenom,jo.poste,jo.score from joueur as jo where jo.club_id='{$clubId}' order by field(jo.poste,'G','D','M','A'), jo.nom");
?>

<div class="titre_page">
	<?php echo $getClubQuery[0]['nom'] ?>
</div>
<div class="colgauche_container">
	<div class="colgauche_gauche">
		<?php
		echo '<img src="'.getURLLogoClub($getClubQuery[0]['id_lequipe']).'" alt="logo '.$getClubQuery[0]['nom'].'"/><br/>';
		?>
	</div>
	<div class="colgauche_droite">
		<div class="sectionPage">
			<div class="sous_titre">Résultats</div>
			<?php
				if ($listMatchsQuery == NULL) {
					echo "Aucun match disputé";
				} else {
					echo "<ul>";
					foreach ($listMatchsQuery as $rencontre) {
						echo "<li>{$rencontre['dateMatch']} <a href='index.php?page=detailClub&clubid={$rencontre['clDomId']}'>{$rencontre['clDomNom']}</a> - <a href='index.php?page=detailClub&clubid={$rencontre['clExtId']}'>{$rencontre['clExtNom']}</a>: <a href='index.php?page=detailMatch&rencontreid={$rencontre['matchId']}'>{$rencontre['buts_club_dom']}-{$rencontre['buts_club_ext']}</a></li>";
					}
					echo "</ul>";
				}
			?>
		</div>
		<div class="sectionPage">
			<div class="sous_titre">Joueurs</div>
			<table class='tableau_liste'>
				<tr><th>Nom</th><th>Poste</th><th></th></tr>
				<?php
				if ($listJoueursQuery != NULL) {
					$cptLigne=0;
					foreach ($listJoueursQuery as $joueur) {
						$classNum = $cptLigne % 2;
						$poste = traduire($joueur['poste']);
						if (isJoueurLibre($joueur['id'])) {
							$scoreFl = '?';
						} else {
							$scoreFl = number_format(round($joueur['score'],2),2);
						}
						echo "<tr class='ligne{$classNum}'><td><a href='index.php?page=detailJoueur&joueurid={$joueur['id']}'>{$joueur['prenom']} {$joueur['nomJoueur']}</td><td>{$poste}</td><td align='right'>{$scoreFl}</td></tr>";
						$cptLigne++;
					}
				}
				?>
			</table>
		</div>
	</div>
</div>
