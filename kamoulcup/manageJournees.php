<?php
	checkAccess(2);
?>
<div class="titre_page">Saisie des notes</div>
<div class="sectionPage">
	<form method="GET" action="index.php">
			Journée de championnat: <select size=1 name="journee">
				<option value=''> </option>
				<?php
				$listJourneeQuery = $db->getArray("select id,numero from journee order by numero asc");
				foreach($listJourneeQuery as $journee) {
					echo "<option value='{$journee[0]}'>Journée {$journee[1]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="manageJournees"/>
			<input type="submit" value="Editer"/>
	</form>
</div>
<?php
	if (isset($_GET['journee'])) {
		$journee=$_GET['journee'];
		$loadJourneeQuery = "select id,numero,date from journee where id='{$journee}' limit 1";
		$storedJournee = $db->getArray($loadJourneeQuery);
		$nouveau = 0;
		if ($storedJournee == NULL) {
			$storedJournee = array(array('id' => '', 'numero' => '', 'date' => ''));
			$nouveau = 1;
		}
		
		include('./div/editJourneeDiv.php');
		$currentJourneeId = $storedJournee[0]['id'];
		include('./div/listMatchsJourneeDiv.php');
	}
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
		
