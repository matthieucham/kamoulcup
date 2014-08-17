<?php
	checkAccess(2);
?>
<div class="titre_page">Saisie des résultats</div>
<div class="sectionPage">
	<form method="POST" action="process/saveMatch.php">
		<?php
			if(isset($_GET['journeeid'])){
				$journeeId=$_GET['journeeid'];
			}
			if (isset($_GET['matchid'])) {
				$matchId=$_GET['matchid'];
				$loadMatchQuery = "select id,club_dom_id,club_ext_id,buts_club_dom,buts_club_ext,journee_id,elimination from rencontre where id='{$matchId}' limit 1";
				$storedMatch = $db->getArray($loadMatchQuery);
				$nouveau = 0;
			}
			if (! isset($storedMatch)) {
					$storedMatch = array(array('id' => '', 'club_dom_id' => '', 'club_ext_id' => '', 'buts_club_dom' => '', 'buts_club_ext' => '', 'journee_id' => '', 'elimination' => 0));
					$nouveau = 1;
				}
		?>
		<table class="tableau_saisie">
					<tbody>
						<tr>
							<th>Journee:</th>
							<td>
								<select size=1 name="journee">
									<?php
										$listJourneesQuery = $db->getArray("select id,numero,date_format(date, '%Y-%m-%d') from journee order by numero asc");
										foreach($listJourneesQuery as $journee) {
											if (isset ($journeeId)) {
												$selected = ($journeeId == $journee[0]);
											} else {
												$selected = false;
											}
											echo "<option";
											if ($selected) {
												echo " selected ";
											}
											echo " value='{$journee[0]}'>J{$journee[1]} du {$journee[2]}</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Match:</th>
							<td>
								<select size=1 name="clubdom">
									<?php
										$listClubsQuery = $db->getArray("select id,nom from club order by nom asc");
										foreach($listClubsQuery as $club) {
											$selected = ($storedMatch[0]['club_dom_id'] == $club[0]);
											echo "<option";
											if ($selected) {
												echo " selected ";
											}
											echo " value='{$club[0]}'>{$club[1]}</option>";
										}
									?>
								</select>
								&nbsp;
								<input type="text" size="4" name="butsdom" value="<?php echo ($storedMatch[0]['buts_club_dom']); ?>"/>
								&nbsp;-&nbsp;
								<input type="text" size="4" name="butsext" value="<?php echo ($storedMatch[0]['buts_club_ext']); ?>"/>
								&nbsp;
								<select size=1 name="clubext">
									<?php
										foreach($listClubsQuery as $club) {
											$selected = ($storedMatch[0]['club_ext_id'] == $club[0]);
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
						<tr>
							<th>Eliminatoire ?</th>
							<td>
								<?php
								echo "<input type=\"checkbox\" name=\"elimination[]\" ";
								if ($storedMatch[0]['elimination']) {
									echo "checked ";
								}
								echo "/>";
								?>
							</td>
						</tr>

					</tbody>
				</table>
				<p><input type="hidden" name="nouveau" value="<?php echo $nouveau; ?>"/></p>
				<p><input type="hidden" name="id" value="<?php echo ($storedMatch[0]['id']); ?>"/></p>
				<p><input type="submit" value="Sauver"/></p>
	</form>
<?php
	if (isset($journeeId)) {
		$currentJourneeId = $journeeId;
		if (isset ($matchId)) {
			echo "<p>» <a href=\"index.php?page=enterNotes&matchId={$matchId}\">Editer les notes des joueurs</a></p>";
		}
		echo "</div>";
		include('div/listMatchsJourneeDiv.php');
	} else {
		echo "</div>";
	}
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>


		
