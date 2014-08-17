<div class="sectionPage">
	<div class='sous_titre'>Périodes programmées</div>
		<?php
				$periodesQuery = $db->getArray("select pe.id,date_format(pe.date_debut,'%d/%m %H:%i'),date_format(pe.date_fin,'%d/%m %H:%i'),pe.delai_encheres,pe.reventes_autorisees,pe.coeff_bonus_achat,po.nom,pe.draft from periode as pe, poule as po where pe.poule_id=po.id order by pe.date_debut desc");
				if ($periodesQuery != NULL) {
					echo "<table class='tableau_liste'>";
					echo "<tr>";
					echo "<th>Date début dépôt</th><th>Date fin dépôt</th><th>DRAFT ?</th><th>Délai d'enchères (en heures)</th><th>RE ?</th><th>Coeff bonus</th><th>Poule</th>";
					echo "</tr>";
					$cpt = 0;
					foreach($periodesQuery as $periode) {
						$classNum = $cpt % 2;
						$rev = 'Non.';
						if ($periode['reventes_autorisees']) {
							$rev = 'Oui.';
						}
						$dra = 'Non.';
						if ($periode['draft']) {
							$dra = '<b>Oui</b>';
						}
						echo "<tr class='ligne{$classNum}'><td>{$periode[1]}</td><td>{$periode[2]}</td><td>{$dra}</td><td>{$periode[3]}</td><td>{$rev}</td><td>{$periode['coeff_bonus_achat']}</td><td>{$periode['nom']}</td></tr>";
						$cpt++;
					}
					echo "</table>";
				} else {
					echo "<p>Aucune période programmée</p>";
				}
		?>
</div>
