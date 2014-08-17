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
							<th>Date (YYYY-MM-DD): </th>
							<td><input type="text" size="10" name="date" value="<?php echo ($storedJournee[0]['date']); ?>"/></td>
						</tr>
					</tbody>
				</table>
				<p><input type="hidden" name="id" value="<?php echo ($storedJournee[0]['id']); ?>"/></p>
				<p><input type="hidden" name="nouveau" value="<?php echo ($nouveau); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
			</form>
		</div>