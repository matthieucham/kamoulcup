<div class="sectionPage">
	<form action="process/addBonus.php" method="POST">
		<table class="tableau_saisie">
			<tbody>
				<tr>
					<th>Type de bonus</th>
					<td>
						<select size=1 name="typeBonus">
							<?php
							 	$unfpET = traduire('UNFP_ET');
								echo "<option value='UNFP_ET'>{$unfpET}</option>";
								$unfpBY = traduire('UNFP_BY');
								echo "<option value='UNFP_BY'>{$unfpBY}</option>";
								$unfpBP = traduire('UNFP_BP');
								echo "<option value='UNFP_BP'>{$unfpBP}</option>";
								$unfpBK = traduire('UNFP_BK');
								echo "<option value='UNFP_BK'>{$unfpBK}</option>";
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th>Valeur</th>
					<td><input type="text" name="valeurBonus"/></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="joueurId" value="<?php echo $joueur; ?>"/>
		<input type="hidden" name="page" value="managePeriodes"/>
		<p><input type="submit" value="Ajouter"/></p>
	</form>
</div>