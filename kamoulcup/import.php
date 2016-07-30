<?php
checkAccess(2);
?>
<div class="titre_page">Import des résultats</div>
<div class="sectionPage">
<form method="POST" action="process/doImport.php"><?php
$toUpdate = $db->getArray("select uuid, numero, eliminatoire from journee where sync_me=1 order by numero asc");
if ($toUpdate == NULL) {
	echo "<p>Il n'y a rien à mettre à jour</p>";
} else {
	echo "<p>Les résultats de ces journées sont à mettre à jour.</p>";
	echo "<table class='tableau_liste'>
			<tr>
				<th>Journée</th><th>Elimination directe ?</th><th>Mettre à jour</th>
			</tr>";
	foreach ($toUpdate as $journee) {
		$checkVal ='';
		if ($journee['eliminatoire'] == 1) {
			$checkVal = ' checked';
		}
		echo "<tr><td align='right'>{$journee['numero']}</td><td><input type=\"checkbox\" name=\"elim[]\" value=\"{$journee['uuid']}\"{$checkVal}/></td><td><input type=\"checkbox\" name=\"syncme[]\" value=\"{$journee['uuid']}\"/></td></tr>";
	}
	echo "</table>";
	echo "<input type='submit' value='Update'/>";
}
?></form>
</div>
