<div class='sectionPage'>
	<div class="sous_titre">Joueurs enregistrés dans ce club</div>
	<ul>
		<?php
			$alertePhoto=false;
			if (strlen($storedClub[0]['id'])>0) {
				$listJoueursQuery = $db->getArray("select id,prenom,nom,id_lequipe from joueur where club_id= '{$storedClub[0]['id']}' order by nom");
			} else {
				$listJoueursQuery = $db->getArray("select id,prenom,nom from joueur where club_id is NULL order by nom");
			}
			if ($listJoueursQuery != NULL) {
				foreach($listJoueursQuery as $joueur) {
					$alertePhoto = !( is_numeric($joueur[id_lequipe]) );
					echo "<li><a href=\"index.php?page=manageJoueurs&id={$joueur[0]}\">{$joueur[1]} {$joueur[2]}</a>";
					if ($alertePhoto) {
						echo " [vérifier photo] ";
					}
					echo "</li>";
				}
			}
		?>
	</ul>
</div>