<?php
	checkAccess(5);
?>
<div class='titre_page'>Gestion des ekyps</div>
<div class="sectionPage">
	<form method="GET" action="index.php">
			Ekyp: <select size=1 name="id">
				<option value=''> </option>
				<?php
				$listEkypQuery = $db->getArray("select id,nom from ekyp order by nom");
				foreach($listEkypQuery as $ekyp) {
					echo "<option value=\"{$ekyp[0]}\">{$ekyp[1]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="manageEkyps"/>
			<input type="submit" value="Editer"/>
	</form>
</div>
<div class="sectionPage">
	<form method="POST" action="process/saveEkyp.php">
		<?php
			$defBudgetQuery = "select valeur from parametres where cle='budget_ekyp' limit 1";
			$defBudget = $db->getArray($defBudgetQuery);
			
			if (isset($_GET['id'])) {
				$ekypId=$_GET['id'];
				$loadEkypQuery = "select id,nom,poule_id,budget,tactique_id,draft_order from ekyp where id='{$ekypId}' limit 1";
				$storedEkyp = $db->getArray($loadEkypQuery);
				$nouveau = 0;
			}
			if (! isset($storedEkyp)) {
					$storedEkyp = array(array('id' => '', 'nom' => '', 'poule_id' => '', 'budget' => ($defBudget[0]['valeur']),'tactique_id' => 0,'draft_order'=>0));
					$nouveau = 1;
				}
		?>
				<table class="tableau_saisie">
					<tr>
						<th>Nom: </th>
						<td><input type="text" size="32" name="nom" value="<?php echo ($storedEkyp[0]['nom']); ?>"/></td>
					</tr>
					<tr>
						<th>Budget: </th>
						<td><input type="text" size="3" name="budget" value="<?php echo ($storedEkyp[0]['budget']); ?>"/></td>
					</tr>
					<tr>
						<th>Poule: </th>
						<td>
							<select size=1 name="poule">
							<?php
								$listPoulesQuery = $db->getArray("select id,nom from poule where ouverte is true order by nom");
								foreach($listPoulesQuery as $poule) {
									$selected = ($storedEkyp[0]['poule_id'] == $poule[0]);
									echo "<option";
									if ($selected) {
										echo " selected ";
									}
									echo " value='{$poule[0]}'>{$poule[1]}</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Managers:</th>
						<td>
							<?php 
							$listManagersQuery = $db->getArray("select nom from utilisateur where ekyp_id = '{$storedEkyp[0]['id']}'");
							if ($listManagersQuery != NULL) {
								foreach($listManagersQuery as $manager) {
								echo $manager['nom'].' ';
								}
							}
							 ?>
						</td>
					</tr>
					<tr>
						<th>Ajouter un manager:</th>
						<td>
							<select size=1 name="newmanager">
							<?php 
								$listFreeManagersQuery = $db->getArray("select id,nom from utilisateur where ekyp_id is null");
								echo "<option value=''> </option>";
								foreach($listFreeManagersQuery as $manager) {
									echo "<option";
									echo " value='{$manager[0]}'>{$manager[1]}</option>";
								}
							 ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Tactique: </th>
						<td>
							<select size=1 name="tactique">
							<?php
								$listTactiquesQuery = $db->getArray("select id,description from tactique");
								foreach($listTactiquesQuery as $tact) {
									$selected = ($storedEkyp[0]['tactique_id'] == $tact[0]);
									echo "<option";
									if ($selected) {
										echo " selected ";
									}
									echo " value='{$tact[0]}'>{$tact[1]}</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<th>Rang à la draft: </th>
						<td><input type="text" size="2" name="draftOrder" value="<?php echo ($storedEkyp[0]['draft_order']); ?>"/></td>
					</tr>
				</table>
				<p><input type="hidden" name="nouveau" value="<?php echo $nouveau; ?>"/></p>
				<p><input type="hidden" name="id" value="<?php echo ($storedEkyp[0]['id']); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
	</form>
</div>
<?php
	if (isset($_GET['id'])) {
		include('./div/editEffectifDiv.php');
	}
?>
<?php
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
