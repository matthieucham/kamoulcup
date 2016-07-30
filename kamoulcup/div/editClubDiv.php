
		<div class='sectionPage'>
			<form method="POST" action="process/saveClub.php">
				<table class="tableau_saisie">
					<tbody>
						<tr>
							<th>Nom: </th>
							<td><input type="text" size="32" name="nom" value="<?php echo ($storedClub[0]['nom']); ?>"/></td>
						</tr>
						<tr>
							<th>Uuid: </th>
							<td><input type="text" size="40" name="uuid" value="<?php echo ($storedClub[0]['uuid']); ?>"/></td>
						</tr>
					</tbody>
				</table>
				<p><input type="hidden" name="id" value="<?php echo ($storedClub[0]['id']); ?>"/></p>
				<p><input type="hidden" name="nouveau" value="<?php echo ($nouveau); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
			</form>
		</div>
