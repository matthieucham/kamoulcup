<p>Date courante: <b><?php echo date('d/m/Y H:i'); ?></b></p>
<div class="sectionPage">
	<div class='sous_titre'>Sessions en cours</div>
		<?php
				$encoursQuery = $db->getArray("select se.id,se.numero,date_format(se.date_pas,'%d/%m %H:%i'),date_format(se.date_encheres,'%d/%m %H:%i'),date_format(se.date_resolution,'%d/%m %H:%i'),po.nom,(se.date_encheres < now()) from session as se,poule as po where se.poule_id = po.id and (se.date_resolution - now() >= 0) and (se.date_pas - now() <= 0) order by se.date_resolution desc");
				if ($encoursQuery != NULL) {
					echo "<table class='tableau_liste'>";
					echo "<tr>";
					echo "<th>Poule</th><th>Numero</th><th>Date début PA</th><th>Date début enchères</th><th>Date fin session</th><th></th>";
					echo "</tr>";
					$cpt = 0;
					foreach($encoursQuery as $session) {
						$etat = 'PAs en cours';
						if ($session[6]) {
							$etat = 'Enchères en cours';
						}
						$classNum = $cpt % 2;
						echo "<tr class='ligne{$classNum}'><td>{$session[5]}</td><td>{$session[1]}</td><td>{$session[2]}</td><td>{$session[3]}</td><td>{$session[4]}</td><td>{$etat}</td></tr>";
						$cpt++;
					}
					echo "</table>";
				} else {
					echo "<p>Aucune session en cours</p>";
				}
		?>
</div>
<div class="sectionPage">
	<div class='sous_titre'>Sessions terminées</div>
		<?php
				$expirQuery = $db->getArray("select se.id,se.numero,date_format(se.date_pas,'%d/%m %H:%i'),date_format(se.date_encheres,'%d/%m %H:%i'),date_format(se.date_resolution,'%d/%m %H:%i'),po.nom from session as se,poule as po where se.poule_id = po.id and (se.date_resolution - now() < 0) order by se.date_resolution desc");
				if ($expirQuery != NULL) {
					echo "<table class='tableau_liste'>";
					echo "<tr>";
					echo "<th>Poule</th><th>Numero</th><th>Date début PA</th><th>Date début enchères</th><th>Date fin session</th><th></th>";
					echo "</tr>";
					$cpt = 0;
					foreach($expirQuery as $session) {
						// La session est-elle résolue entièrement ? 
						$resolutionQuery  = $db->getArray("select id from vente where resolue=0 and session_id = '{$session[0]}'");
						$resol = 'Résolue';
						if ($resolutionQuery != NULL) {
							$resol = 'Résoudre';
						}
						$classNum = $cpt % 2;
						echo "<tr class='ligne{$classNum}'><td>{$session[5]}</td><td>{$session[1]}</td><td>{$session[2]}</td><td>{$session[3]}</td><td>{$session[4]}</td><td>» <a href=\"index.php?page=resoudre&sessionId={$session[0]}\">{$resol}</a></td></tr>";
						$cpt++;
					}
					echo "</table>";
				} else {
					echo "<p>Aucune session terminée</p>";
				}
		?>
</div>
<div class="sectionPage">	
	<div class='sous_titre'>Sessions à venir</div>
	
		<?php
				$futurQuery = $db->getArray("select se.id,se.numero,date_format(se.date_pas,'%d/%m %H:%i'),date_format(se.date_encheres,'%d/%m %H:%i'),date_format(se.date_resolution,'%d/%m %H:%i'),po.nom from session as se,poule as po where se.poule_id = po.id and (se.date_pas - now() > 0) order by se.date_resolution desc");
				if ($futurQuery != NULL) {
					echo "<form action=\"process/supprSession.php\" method=\"POST\">";
					echo "<table class='tableau_liste'>";
					echo "<tr>";
					echo "<th>Poule</th><th>Numero</th><th>Date début PA</th><th>Date début enchères</th><th>Date fin session</th><th>Suppr.</th>";
					echo "</tr>";
					$cpt = 0;
					foreach($futurQuery as $session) {
						$classNum = $cpt % 2;
						echo "<tr class='ligne{$classNum}'><td>{$session[5]}</td><td>{$session[1]}</td><td>{$session[2]}</td><td>{$session[3]}</td><td>{$session[4]}</td><td><input type=\"checkbox\" name=\"suppr[]\" value=\"{$session[0]}\"/></td></tr>";
						$cpt++;
					}
					echo "</table>";
					echo "<input type=\"submit\" value=\"Supprimer sélection\"/>";
					echo "</form>";
				} else {
					echo "<p>Aucune session prévue</p>";
				}
	?>
</div>