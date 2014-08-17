<div class="sous_titre">Tête de gondole</div>
	<i>Les meilleurs joueurs libres</i>
	<?php
		$listPoulesQuery = $db->getArray("select id,nom from poule");
		foreach($listPoulesQuery as $poule) {
			echo "<p>{$poule['nom']}</p>";
			$pouleId = $poule['id'];
			$meilleursJoueursQuery = "select jo.id, jo.prenom, jo.nom, jo.id_lequipe, jo.score from joueur as jo where jo.id not in (select tr.joueur_id from transfert as tr where tr.poule_id='{$pouleId}') order by jo.score desc limit 3";
			$meilleursJoueurs = $db->getArray($meilleursJoueursQuery);
			if ($meilleursJoueurs != NULL) {
				// Le meilleur : Photo
				echo "<table class='tableau_horizon' width='100%'>";
				$photo = getURLPhotoJoueur($meilleursJoueurs[0]['id_lequipe']);
				$scoreFl = number_format(round(floatval($meilleursJoueurs[0]['score']),2),2);
				echo "<tr><th>1er</th><td><img src='{$photo}'/><br/><a href='index.php?page=detailJoueur&joueurid={$meilleursJoueurs[0]['id']}'>{$meilleursJoueurs[0]['prenom']} {$meilleursJoueurs[0]['nom']}</a></td><td class='ligne_bilan'>{$scoreFl}</td></tr>";
				$scoreFl = number_format(round(floatval($meilleursJoueurs[1]['score']),2),2);
				echo "<tr><th>2e</th><td><a href='index.php?page=detailJoueur&joueurid={$meilleursJoueurs[1]['id']}'>{$meilleursJoueurs[1]['prenom']} {$meilleursJoueurs[1]['nom']}</a></td><td class='ligne_bilan'>{$scoreFl}</td></tr>";
				$scoreFl = number_format(round(floatval($meilleursJoueurs[2]['score']),2),2);
				echo "<tr><th>3e</th><td><a href='index.php?page=detailJoueur&joueurid={$meilleursJoueurs[2]['id']}'>{$meilleursJoueurs[2]['prenom']} {$meilleursJoueurs[2]['nom']}</a></td><td class='ligne_bilan'>{$scoreFl}</td></tr>";
				echo "</table>";
			}
		}		
	?>
