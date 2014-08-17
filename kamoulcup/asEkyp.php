<?php
	checkAccess(5);
?>
<div class='titre_page'>Prendre temporairement le contrôle d'une ékyp</div>
<div class="sectionPage">
	<form method="POST" action="process/takeEkyp.php">
			Ekyp: <select size=1 name="id">
				<option value=''> </option>
				<?php
				$listEkypQuery = $db->getArray("select id,nom from ekyp order by nom");
				foreach($listEkypQuery as $ekyp) {
					echo "<option value=\"{$ekyp[0]}\">{$ekyp[1]}</option>";
				}
				?>
			</select>
			<input type="submit" value="Choisir"/>
	</form>
</div>