<?php
include("../../includes/db.php");
include("../ctrl/accessManager.php");
checkAdminAccess();
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
  $(function() {
	  $( "#tabs" ).tabs();
	  });
  </script>
</head>
<body>
<h1>Kamoul Manager : Administration</h1>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Effectifs et scores</a></li>
	<li><a href="#tabs-2">Transferts et finances</a></li>
	<li><a href="#tabs-3">Championnats</a></li>
</ul>
<div id="tabs-1">
<h2>Step 1: Sélections des franchises</h2>
<p>Evolution possible : chaque franchise remplit sa feuille de match</p>
<form method="post" action="process/updateSelections.php">
<p>Valider les compositions de la journée <select size=1 name="journee">
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
</div>
<div id="tabs-2">
<h2>Gestion des transferts</h2>
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
<p>Ouvrir un mercato du <input type="text" id="mercatoD_datepicker"
	name="mercatoFrom"> au <input type="text" id="mercatoF_datepicker"
	name="mercatoTo"> Heure <input name="mercatoTime" size="4"
	maxlength="2" />:00 <input type="submit" value="créer" /></p>
</form>
</div>
<div id="tabs-3">
<h2>Inscription des franchises</h2>
<form method="POST" action="process/registerEkyps.php">
<p>Franchises : <select multiple name='inscrits[]' size='20'>
<?php
$franchisesQ = "select id,nom,km from ekyp order by nom asc";
$franchises = $db->getArray($franchisesQ);
if (franchises != NULL) {
	foreach ($franchises as $value) {
		$frId = $value['id'];
		$frNom = $value['nom'];
		echo "<option value='{$frId}'";
		if (intval($value['km'])==1) {
			echo " selected";
		}
		echo ">{$frNom}</option>";
	}
}
?>
</select><input type="submit" value="inscrire" /></p>
</form>
<h2>Lancer un championnat</h2>
<form method="POST" action="process/createChampionnat.php">
<p>Franchises : <select multiple name='ekyps[]' size='20'>
<?php
$franchisesQ = "select id,nom,km from ekyp where km=1 order by nom asc";
$franchises = $db->getArray($franchisesQ);
if ($franchises != NULL) {
	foreach ($franchises as $value) {
		$frId = $value['id'];
		$frNom = $value['nom'];
		echo "<option value='{$frId}'";
		if (intval($value['km'])==1) {
			echo " selected";
		}
		echo ">{$frNom}</option>";
	}
}
?>
</select> Nom:<input name="nom" /> Démarre après la J <select size=1
	name="jStart">
	<?php
	if ( $listJourneesQuery != NULL) {
		echo "<option value=\"0\">0</option>";
		foreach($listJourneesQuery as $journee) {
			echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
		}
	}
	?>
</select> Nombre de journées=<input name="nbJ" size="2" maxlength="2" />
<input type="submit" value="creer" /></p>
</form>
<h2>Rattacher des franchises à un championnat existant</h2>
<form action="process/attachChampionnat.php" method="post">
<p>Rattacher les franchises <select multiple name='ekyps[]' size='20'>
<?php
if (franchises != NULL) {
foreach ($franchises as $value) {
		$frId = $value['id'];
		$frNom = $value['nom'];
		echo "<option value='{$frId}'";
		if (intval($value['km'])==1) {
			echo " selected";
		}
		echo ">{$frNom}</option>";
	}
}
?>
</select> 
au championnat <select name='championnat'>
<?php
$champQ = "select chp_id,chp_nom,chp_nb_journees from km_championnat order by chp_first_journee_id desc";
$champ = $db->getArray($champQ);
if ($champ != NULL) {
	foreach ($champ as $value) {
		$chId = $value['chp_id'];
		$chNom = $value['chp_nom'];
		$nbJ = $value['chp_nb_journees'];
		echo "<option value='{$chId}'";
		echo ">{$chNom} [{$nbJ}]</option>";
	}
}
?>
</select> <input type="submit" value="associer"/></p>
</form>
</div>
</div>
</body>
</html>
