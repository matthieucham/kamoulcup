<?php
include("../../includes/db.php");
include("../../process/checkAccess.php");
checkaccess(5);
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Kamoul Manager Admin</title>
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
  $(function() {
	  $( "#mercatoD_datepicker" ).datepicker();
    $( "#mercatoD_datepicker" ).datepicker("option","dateFormat","yy-mm-dd");
    $( "#mercatoF_datepicker" ).datepicker();
    $( "#mercatoF_datepicker" ).datepicker("option","dateFormat","yy-mm-dd");
  });
  </script>
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

<h1>Gestion des transferts</h1>
<ul>
<?php
$mercatos = $db->getArray("select mer_id,mer_date_ouverture,mer_date_fermeture from km_mercato where mer_processed=0 order by mer_date_ouverture asc");
if ($mercatos != NULL) {
	foreach ($mercatos as $value) {
		echo '<form method="post" action="process/resolveMercato.php"><input type="hidden" name="mercatoId" value="'.$value[0].'"/><li>'.$value[0].' du '.$value[1].' au '.$value[2].'<input type="submit" value="résoudre" />'.'</form></li>';
	}
}
?>
</ul>
<form method="post" action="process/createMercato.php">
<p>Ouvrir un mercato du <input type="text" id="mercatoD_datepicker" name="mercatoFrom"> au <input type="text" id="mercatoF_datepicker" name="mercatoTo"> Heure <input name="mercatoTime" size="4" maxlength="2" />:00 <input type="submit" value="créer" /></p>
</form>

</body>
</html>
