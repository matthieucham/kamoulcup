<?php
	checkAccess(1);
	checkEkyp();
	if (! isset($_GET['joueurId'])) {
		echo '<p class=\"error\">Pas de joueurId !</p>';
		exit;
	}
	$getJoueurQuery = $db->getArray("select id, nom, prenom from joueur where id='{$_GET['joueurId']}' limit 1")
?>


	<div class='titre_page'>Revendre un joueur</div>
	<div class="sectionPage">
	<?php
		echo "<a href='index.php?page=detailJoueur&joueurid={$getJoueurQuery[0]['id']}'>{$getJoueurQuery[0]['prenom']} {$getJoueurQuery[0]['nom']}</a>"
	?>
	<form method="POST" action="index.php">
		<input type='hidden' name='page' value='postRevente'/>
		<input type='hidden' name='type' value='MV'/>
		<input type='hidden' name='joueurId' value='<?php echo $getJoueurQuery[0]['id']; ?>'/>
		<input type='hidden' name='nom' value='<?php echo $getJoueurQuery[0]['nom']; ?>'/>
		<input type='hidden' name='prenom' value='<?php echo $getJoueurQuery[0]['prenom']; ?>'/>
		
		<table class="tableau_saisie">
			<tr>
				<th>Prix de vente affiché: </th>
				<td><input type="text" size="4" name="montant"/> Ka</td>
			</tr>
			<tr>
				<th>Prix de réserve secret (facultatif): </th>
				<td><input type="text" size="4" name="reserve"/> Ka</td>
			</tr>
		</table>
		<input type="submit" value="Envoyer"/>
	</form>
</div>	
<?php
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>