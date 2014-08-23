<?php
include("../../includes/db.php");
include("../../process/checkAccess.php");
checkaccess(5);
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Kamoul Manager Admin</title>
</head>
<body>
<h1>Kamoul Manager : Administration</h1>
<h2>Step 1: Sélections des franchises</h2>
<p>Evolution possible : chaque franchise remplit sa feuille de match</p>
<form method="post" action="process/updateSelections.php">
<p>Sélections de la journée <select size=1 name="journee">
<?php
$listJourneesQuery = $db->getArray("select id,numero from journee order by numero asc");
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
?>
</select> <input type="submit" value="update" /></p>
</form>

<h2>Step 2: Scores des joueurs</h2>
<form method="post" action="process/updateScores.php">
<p>Scores de la journée <select size=1 name="journee">
<?php
$listJourneesQuery = $db->getArray("select id,numero from journee order by numero asc");
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
?>
</select> <input type="submit" value="update" /></p>
</form>

<h2>Step 3: Salaires</h2>
<form method="post" action="process/updateSalaires.php">
<p>Salaires après la journée <select size=1 name="journee">
<?php
$listJourneesQuery = $db->getArray("select id,numero from journee order by numero asc");
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
?>
</select> <input type="submit" value="update" /></p>
</form>

<h2>Step X: Initialiser les classes de salaire basées sur les perfs de
l'année d'avant</h2>
<form method="post" action="process/initSalaires.php">
<p>Score référence <select size=1 name="champ">
	<option value="score1">Apertura</option>
	<option value="score2">Clausura</option>
	<option value="score">Saison</option>
</select> <input type="submit" value="init" /></p>
</form>
</body>
</html>
