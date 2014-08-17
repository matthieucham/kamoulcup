<div class="sous_titre">Sur le marché</div>
	<i>En vente en ce moment !</i>
	<?php
		$listPoulesQuery = $db->getArray("select id,nom from poule");
		foreach($listPoulesQuery as $poule) {
			echo "<p>{$poule['nom']}</p>";
			$pouleId = $poule['id'];
			$enVenteQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as fin from joueur as jo, vente as ve where (ve.joueur_id=jo.id) and (now() < ve.date_finencheres) and poule_id={$pouleId} order by ve.date_soumission asc");
			if ($enVenteQuery  != NULL) {
				echo "<table class='tableau_liste' width='100%'>";
				echo "<tr><th>Joueur</th><th>Jusqu'au</th></tr>";
				$cptLigne=0;
				foreach($enVenteQuery as $enVente) {
					$classNum = $cptLigne % 2;
					echo "<tr class='ligne{$classNum}'><td><a href=\"index.php?page=detailJoueur&joueurid={$enVente['id']}\">{$enVente['prenom']} {$enVente['nom']}</a></td><td>{$enVente['fin']}</td></tr>";
					$cptLigne++;
				}
				echo "</table>";
			} else {
				echo "<p align='center'><i>Personne</i></p>";
			}
		}		
	?>
