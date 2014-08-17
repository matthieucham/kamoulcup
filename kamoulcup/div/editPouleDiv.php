<div class="sectionPage">
	<div class='sous_titre'>Edition</div>
			<form method="POST" action="process/savePoule.php">
				
				<table class="tableau_saisie">
					<tbody>
						<tr>
							<th>Nom: </th>
							<td><input type="text" size="32" name="nom" value="<?php echo ($storedPoule[0]['nom']); ?>"/></td>
						</tr>
						<tr>
							<th>Poule ouverte: </th>
							<td><input type="checkbox" name="ouverte" <?php echo ($storedPoule[0]['ouverte']== true)?" checked":"";?>"/></td>
						</tr>
					</tbody>
				</table>
				<p><input type="hidden" name="id" value="<?php echo ($storedPoule[0]['id']); ?>"/></p>
				<p><input type="hidden" name="nouveau" value="<?php echo ($nouveau); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
			</form>
		</div>