<?php
checkAccess(2);
?>
<div class="titre_page">Import terminé</div>
<div class="sectionPage">
<form method="POST" action="process/setJoueursPostes.php"><?php
$sansPoste = $db->getArray("select jo.id as joid, jo.prenom, jo.nom as jonom, cl.nom as clnom from joueur jo inner join club cl on cl.id=jo.club_id where poste is null");
if ($sansPoste == NULL) {
	echo "<p><a href='process/calculScores.php'>Recalculer les scores</a></p>";
} else {
	echo "<p>Il faut attribuer un poste au(x) joueur(s) suivant(s) issu(s) de l'import:</p>";
	echo "<p>Il faut respecter la nomenclature donnée par les sites officiels des clubs.</p>";
	echo "<table class='tableau_liste'>
			<tr>
				<th>Joueur</th><th>Club</th><th>Poste</th>
			</tr>";
	foreach ($sansPoste as $joueur) {
		echo "<tr><td><input type='hidden' name='joueurid[]' value='{$joueur['joid']}' />{$joueur['prenom']} {$joueur['jonom']}</td><td>{$joueur['clnom']}</td><td><select name=\"poste[]\">";
		echo "<option value='G'>Gardien</option>";
		echo "<option value='D'>Défenseur</option>";
		echo "<option value='M'>Milieu</option>";
		echo "<option value='A'>Attaquant</option>";
		echo "</select></td></tr>";
	}
	echo "</table>";
	echo "<input type='submit' value='Enregistrer et recalculer les scores'/>";
}
?></form>
</div>
