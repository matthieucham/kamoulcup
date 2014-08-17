<?php
	checkAccess(1);
?>

<div class="formDiv">
	<div class='titre_page'>Changer de mot de passe</div>
	<form method="POST" action="process/savePassword.php">
		<table class="tableau_saisie">
			<tbody>
				<tr>
					<th>Mot de passe actuel: </td>
					<td><input type="password" size="32" name="actuel"/></td>
				</tr>
				<tr>
					<th>Nouveau mot de passe: </td>
					<td><input type="password" size="32" name="nouveau1"/></td>
				</tr>
				<tr>
					<th>Tapez le à nouveau: </td>
					<td><input type="password" size="32" name="nouveau2"/></td>
				</tr>
			</tbody>
		</table>
		<p><input type="submit" value="Sauver"/></p>
	</form>
</div>	
<?php
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>