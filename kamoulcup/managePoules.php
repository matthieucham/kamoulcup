<?php

	checkAccess(5);
?>

<div class='titre_page'>Gestion des poules</div>
	<div class="sectionPage">
		<form method="GET" action="index.php">
			Poule: <select size=1 name="poule">
				<option value=''> </option>
				<?php
				$listPoulesQuery = $db->getArray("select nom from poule order by nom");
				foreach($listPoulesQuery as $poule) {
					echo "<option>{$poule[0]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="managePoules"/>
			<input type="submit" value="Editer"/>
		</form>
	</div>
<?php
	if (isset($_GET['poule'])) {
		$pouleName=$_GET['poule'];
		$getPouleQuery = "select id,nom,ouverte from poule where nom='{$pouleName}' limit 1";
		$storedPoule = $db->getArray($getPouleQuery);
		$nouveau = 0;
		if ($storedPoule == NULL) {
			$storedPoule = array(array('id' => '', 'nom' => '', 'ouverte' => '1'));
			$nouveau = 1;
		}
		include('./div/editPouleDiv.php');
		include('./div/listEkypsPouleDiv.php');
	}
?>