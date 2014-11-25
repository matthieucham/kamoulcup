<div class="sectionPage">
	<div class="sous_titre">Edition des journées</div>
			<form method="POST" action="process/saveJournee.php">
				<table class="tableau_saisie">
					<tbody>
						<tr>
							<th>Numero: </th>
							<td><input type="text" size="2" name="numero" value="<?php echo ($storedJournee[0]['numero']); ?>"/></td>
						</tr>
						<tr>
							<th>Date (YYYY-MM-DD HH:mm): </th>
							<td><input type="text" size="20" name="date" value="<?php echo ($storedJournee[0]['date']); ?>"/></td>
						</tr>
					</tbody>
				</table>
                <p><b>Important et nouveau: </b> Dans le champ Date, renseignez désormais la date <b>ET L'HEURE</b> du <b>PREMIER MATCH</b> de la journée. Si un match est avancé, par ex vendredi à 20h, il faut mettre la date et l'heure de ce match ("20:00" pour 20h).</p>
				<p><input type="hidden" name="id" value="<?php echo ($storedJournee[0]['id']); ?>"/></p>
				<p><input type="hidden" name="nouveau" value="<?php echo ($nouveau); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
			</form>
		</div>