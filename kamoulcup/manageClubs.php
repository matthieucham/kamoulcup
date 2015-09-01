<?php
	checkAccess(3);
?>
	<div class='titre_page'>Edition des clubs</div>
	<div class='sectionPage'>
	<form method="GET" action="index.php">
			Club: <select size=1 name="club">
				<option value=''> </option>
				<?php
				$listClubsQuery = $db->getArray("select id,nom from club order by nom");
				foreach($listClubsQuery as $club) {
					echo "<option value={$club[0]}>{$club[1]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="manageClubs"/>
			<input type="submit" value="Editer"/>
	</form>
	</div>

<?php
	if (isset($_GET['club'])) {
		$clubId=$_GET['club'];
		$loadClubQuery = "select id,nom,id_lequipe,uuid from club where id='{$clubId}' limit 1";
		$storedClub = $db->getArray($loadClubQuery);
		$nouveau = 0;
		if ($storedClub == NULL) {
			$storedClub = array(array('id' => '', 'nom' => '', 'id_lequipe' => '', 'uuid' => ''));
			$nouveau = 1;
		}
		include('./div/editClubDiv.php');
		include('./div/listJoueursClubDiv.php');
		$clubUuid = $storedClub[0]['uuid'];
		$clubId = $storedClub[0]['id'];
		echo "<form method='POST' action='process/importClub.php'><input type='hidden' name='clubid' value='{$clubId}'/><input type='hidden' name='clubuuid' value='{$clubUuid}'/><input type='submit' value='Importer effectif'/></form>";
	}
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
		
