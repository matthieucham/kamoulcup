<?php
	checkAccess(3);
?>

<div class="sectionPage">
	<div class='titre_page'>Edition des joueurs</div>
	<form method="POST" action="process/saveJoueur.php">
		<?php
			if (isset($_GET['id'])) {
				$joueurId=$_GET['id'];
				$loadJoueurQuery = "select id,nom,prenom,id_lequipe,club_id,poste,id_ws from joueur where id='{$joueurId}' limit 1";
				$storedJoueur = $db->getArray($loadJoueurQuery);
				$nouveau = 0;
			}
			if (! isset($storedJoueur)) {
					$storedJoueur = array(array('id' => '', 'nom' => '', 'prenom' => '', 'id_lequipe' => '', 'id_ws' =>'', 'club_id' => '', 'poste' => ''));
					$nouveau = 1;
				}
		?>
				<table class="tableau_saisie">
					<tbody>
						<tr>
							<th>Nom: </th>
							<td><input type="text" size="32" name="nom" value="<?php echo ($storedJoueur[0]['nom']); ?>"/></td>
						</tr>
						<tr>
							<th>Prénom: </th>
							<td><input type="text" size="32" name="prenom" value="<?php echo ($storedJoueur[0]['prenom']); ?>"/></td>
						</tr>
						<tr>
							<th>Poste: </th>
							<td>
								<select size="1" name="position">
									<option value="G" 
										<?php if ($storedJoueur[0]['poste'] == 'G') {	echo ' selected';}	?>
									>Gardien</option>
									<option value="D" 
										<?php if ($storedJoueur[0]['poste'] == 'D') {	echo ' selected';}	?>
									>Défenseur</option>
									<option value="M" 
										<?php if ($storedJoueur[0]['poste'] == 'M') {	echo ' selected';}	?>
									>Milieu</option>
									<option value="A" 
										<?php if ($storedJoueur[0]['poste'] == 'A') {	echo ' selected';}	?>
									>Attaquant</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>Id L'Equipe: </th>
							<td><input type="text" size="10" name="id_lequipe" value="<?php echo ($storedJoueur[0]['id_lequipe']); ?>"/></td>
						</tr>
						<tr>
							<th>Id Whoscored: </th>
							<td><input type="text" size="10" name="id_ws" value="<?php echo ($storedJoueur[0]['id_ws']); ?>"/></td>
						</tr>
						<tr>
							<th>Club: </th>
							<td>
								<select size=1 name="club">
									<option value=''> </option>
									<?php
										$listClubsQuery = $db->getArray("select id,nom from club order by nom");
										foreach($listClubsQuery as $club) {
											$selected = ($storedJoueur[0]['club_id'] == $club[0]);
											echo "<option";
											if ($selected) {
												echo " selected ";
											}
											echo " value='{$club[0]}'>{$club[1]}</option>";
										}
									?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
				<p><input type="hidden" name="nouveau" value="<?php echo $nouveau; ?>"/></p>
				<p><input type="hidden" name="id" value="<?php echo ($storedJoueur[0]['id']); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
	</form>
</div>	
<?php
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>