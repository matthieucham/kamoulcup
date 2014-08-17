<?php
	checkAccess(4);
?>

<div class='titre_page'>Gérer le palmarès</div>
<div class="sectionPage">
	<form method="POST" action="process/savePalmares.php">
		<table class="tableau_saisie">
			<tbody>
				<tr>
					<th>Nom du trophée</th>
					<td><input type="text" name="nomTrophee"/></td>
				</tr>
				<tr>
					<th>Poule</th>
					<td>
							<select size=1 name="poule">
							<?php
								$listPoulesQuery = $db->getArray("select id,nom from poule order by nom");
								foreach($listPoulesQuery as $poule) {
									echo "<option value='{$poule[0]}'>{$poule[1]}</option>";
								}
							?>
							</select>
					</td>
				</tr>
				<tr>
					<th>Classement à générer</th>
					<td>
							<select size=1 name="score">
								<option value="0">Saison</option>
								<option value="1">Apertura</option>
								<option value="2">Clausura</option>
							</select>
					</td>
				</tr>
			</tbody>
		</table>
		<p><input type="submit" value="Figer le palmarès courant"/></p>
	</form>
</div>
<?php
	
	
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
