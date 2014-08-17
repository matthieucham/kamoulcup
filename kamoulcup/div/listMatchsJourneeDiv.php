<div class="sectionPage">
	<div class="sous_titre">Matchs de cette journée</div>
	<ul>
		<?php
				$listMatchsQuery = $db->getArray("select ma.id,cl1.nom,cl2.nom,ma.buts_club_dom,ma.buts_club_ext from rencontre as ma, club as cl1, club as cl2 where ma.club_dom_id = cl1.id and ma.club_ext_id = cl2.id and ma.journee_id = '{$currentJourneeId}'");
				if ($listMatchsQuery != NULL) {
					foreach($listMatchsQuery as $match) {
						echo "<li><a href=\"index.php?page=manageMatchs&journeeid={$currentJourneeId}&matchid={$match[0]}\">{$match[1]} {$match[3]}-{$match[4]} {$match[2]}</a></li>";
					}
				}
		?>
	</ul>
	<p><?php echo "» <a href=\"index.php?page=manageMatchs&journeeid={$currentJourneeId}\">Ajouter un match</a>" ?></p>
</div>