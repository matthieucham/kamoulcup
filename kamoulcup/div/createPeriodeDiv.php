<div class="sectionPage">
	<div class='sous_titre'>Créer une période de vente</div>
	<form method="POST" action="process/savePeriode.php">
		<?php
		  $delaiDefaut = $db->getArray("select valeur from parametres where cle='duree_periode_encheres' limit 1");

		  $defaultStartDate = date('Y-m-d H:i:s');
		  $defaultCoeff = 0;
		?>
		<table class="tableau_saisie">
			<tbody>
				<tr>
					<th>Date de début</th>
					<td><input type="text" name="dateDebut" value="<?php echo $defaultStartDate; ?>"/></td>
				</tr>
				<tr>
					<th>Date de fin</th>
					<td><input type="text" name="dateFin" value="<?php echo $defaultStartDate; ?>"/></td>
				</tr>
				<tr>
					<th>Durée des enchères de cette période, en heures</th>
					<td><input type="text" name="delaiEncheres" value="<?php echo $delaiDefaut; ?>"/></td>
				</tr>
				<tr>
					<th>Est-ce la draft ?</th>
					<td>
						<select size="1" name="draft">
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Reventes à la BA autorisées ?</th>
					<td>
						<select size="1" name="revente">
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>Coefficient de bonus d'achat (décimal)</th>
					<td><input type="text" name="coeffAchat" value="<?php echo $defaultCoeff; ?>"/></td>
				</tr>
				<tr>
						<th>Poule: </th>
						<td>
							<select size=1 name="poule">
							<?php
								$listPoulesQuery = $db->getArray("select id,nom from poule order by nom");
								foreach($listPoulesQuery as $poule) {
									echo "<option";
									echo " value='{$poule[0]}'>{$poule[1]}</option>";
								}
							?>
							</select>
						</td>
					</tr>
			</tbody>
		</table>
		<input type="hidden" name="page" value="managePeriodes"/>
		<p><input type="submit" value="Ajouter"/></p>
	</form>
</div>