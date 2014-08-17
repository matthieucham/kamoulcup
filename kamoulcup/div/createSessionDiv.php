<div class="sectionPage">
	<div class='sous_titre'>Créer une nouvelle session</div>
	<form method="POST" action="process/saveSession.php">
		<?php
		  $loadPoulesQuery = $db->getArray("select id,nom from poule order by nom");
		  $dureePa = $db->getArray("select valeur from parametres where cle='duree_session_pas' limit 1");
		  $numSessionDb = $db->getArray("select max(numero) from session");
		  if ($numSessionDb != NULL) {
		  	$numSession = $numSessionDb[0][0] + 1;
		  } else {
		  	$numSession = 1;
		  }
		  $dureeEnchere = $db->getArray("select valeur from parametres where cle='duree_session_enchere' limit 1");
		  $heureDebut = $db->getArray("select valeur from parametres where cle='heure_debut_session' limit 1");
		  $heureFin = $db->getArray("select valeur from parametres where cle='heure_fin_session' limit 1");
		  $defaultStartDate = date('Y-m-d H:i:s', mktime($heureDebut[0][0], 0, 0, date("m")  , date("d")+1, date("Y")));
		  $defaultEnchereDate = date('Y-m-d H:i:s',mktime($heureFin[0][0], 0, 0, date("m")  , date("d")+1+$dureePa[0][0], date("Y")));
		  $defaultResolutionDate = date('Y-m-d H:i:s',mktime($heureFin[0][0], 0, 0, date("m")  , date("d")+1+$dureePa[0][0]+$dureeEnchere[0][0], date("Y")));
		?>
		<table class="tableau_saisie">
			<tbody>
				<tr>
					<th>Poule: </th>
					<td>
						<select name="poule">
						<?php
							if ($loadPoulesQuery != NULL) {
								foreach($loadPoulesQuery as $poule) {
									echo "<option value=\"{$poule[0]}\">{$poule[1]}</option>";
								}
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<th>Numéro</th>
					<td><input type="text" name="numero" value="<?php echo $numSession; ?>"/></td>
				</tr>
				<tr>
					<th>Date début dépôt PAs</th>
					<td><input type="text" name="dateDebut" value="<?php echo $defaultStartDate; ?>"/></td>
				</tr>
				<tr>
					<th>Date fin dépôt PAs et début enchères</th>
					<td><input type="text" name="dateEnchere" value="<?php echo $defaultEnchereDate; ?>"/></td>
				</tr>
				<tr>
					<th>Date fin enchères</th>
					<td><input type="text" name="dateResolution" value="<?php echo $defaultResolutionDate; ?>"/></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="page" value="manageSessions"/>
		<p><input type="submit" value="Sauver"/></p>
	</form>
</div>