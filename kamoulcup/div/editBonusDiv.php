<p>Bonus obtenus</p>
		<form action="process/supprBonus.php" method="POST">
		<table class="tableau_liste_centre">
			<tr><th>Type</th><th>Valeur</th><th>Suppr.</th></tr>
			<?php
			if ($storedBonus != NULL) {
				$i=0;
				$bonusIds = Array();
				$types = Array();
				$valeurs = Array();
				$cancelled = Array();
				$cptLigne = 0;
				foreach($storedBonus as $bonus) {
					$classNum = $cptLigne % 2;
					echo "<tr class='ligne{$classNum}'>";
					$cptLigne++;
					$type = traduire($bonus['type']);
					$valeur = number_format(round(floatval($bonus['valeur']),2),2);
					echo "<td>{$type}</td><td>{$valeur}</td>";
					echo "<td><input type=\"checkbox\" name=\"cancelled[]\" value=\"{$bonus['id']}\" /></td></tr>";
				}
			}
			?>
		</table>
		<input type="hidden" name="page" value="manageBonus"/>
		<input type="hidden" name="joueurId" value="<?php echo $joueur; ?>"/>
		<input type="submit" value="Supprimer"/>
	</form>
