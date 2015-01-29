<?php
include("../../includes/db.php");
include("../ctrl/accessManager.php");
checkAdminAccess();

$listJourneesQuery = $db->getArray("select id,numero from journee order by numero asc");
$listChampionnatsQuery = $db->getArray("select chp_id,chp_nom,chp_first_journee_numero,chp_last_journee_numero from km_championnat order by chp_nom asc");

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
    <li><a href="#tabs-5">Championnats du jeu</a></li>
    <li><a href="#tabs-4">Franchises</a></li>
	<li><a href="#tabs-3">Championnats</a></li>
    <li><a href="#tabs-2">Gestion des transferts</a></li>
</ul>
<div id="tabs-1">
    <h2>Scores et salaires des joueurs</h2>
    <table>
        <tr>
            <th></th><th></th><th>par journée</th><th>global</th>
        </tr>
        <tr>
            <td>1</td><td>MAJ scores</td><td>
            <form method="post" action="process/updateScores.php">
                <select size=1 name="journee">
                    <?php
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
                    ?>
                </select> 
                <input type="submit" value="journee" />
            </form>
            </td>
            <td>
            <form method="post" action="process/updateScores.php">
                <input type='hidden' name='journee' value='0' />
                <input type="submit" value="global" />
            </form>
            </td>
        </tr>
        <tr>
            <td>2</td><td>MAJ salaires</td><td>
            <form method="post" action="process/updateSalaires.php">
                <select size=1 name="journee">
                    <?php
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
                    ?>
                </select> 
                <input type="submit" value="journee" />
            </form>
            </td>
            <td>
            <form method="post" action="process/updateSalaires.php">
                <select size=1 name="journee">
                    <?php
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
                    ?>
                </select> 
                <input type='hidden' name='global' value='1' />
                <input type="submit" value="global" />
            </form>
            </td>
        </tr>
    </table>
<!-- c'est dangereux
<h2>Step X: Initialiser les classes de salaire basées sur les perfs de
l'année d'avant</h2>
<form method="post" action="process/initSalaires.php">
<p>Score référence <select size=1 name="champ">
	<option value="score1">Apertura</option>
	<option value="score2">Clausura</option>
	<option value="score">Saison</option>
</select> <input type="submit" value="init" /></p>
</form>
-->
</div>
    
<div id="tabs-4">
    <h2>Créer une Franchise</h2>
    <form method="post" action="process/createFranchise.php">
        <p>Nom = <input type='text' size='50' maxlength="256" name="nomFranchise" /> Propriétaire = 
<?php
    echo "<select size=1 name='user'>";
    $users = $db->getArray( "select id,nom from utilisateur where franchise_id is null order by nom asc");
    foreach($users as $u) {
        echo "<option value='{$u['id']}'>{$u['nom']}</option>";
    }
    echo "</select>";
?>
     <input type="submit" value="creer" />   </p>
    </form>
</div>
<div id="tabs-2">
<h2>Gestion des transferts</h2>
<ul>
<?php
$mercatos = $db->getArray("select mer_id,mer_date_ouverture,mer_date_fermeture from km_mercato where mer_processed=0 and mer_date_fermeture < now() order by mer_date_ouverture asc");
if ($mercatos != NULL) {
	foreach ($mercatos as $value) {
		echo '<form method="post" action="process/resolveMercato.php"><input type="hidden" name="mercatoId" value="'.$value[0].'"/><li>'.$value[0].' du '.$value[1].' au '.$value[2].'<input type="submit" value="résoudre" />'.'</form></li>';
	}
}
?>
</ul>
<form method="post" action="process/createMercato.php">
<p>Ouvrir un mercato pour le(s) championnat(s) <select multiple name='championnats[]' size='4'>
<?php
    $championnats = $db->getArray("select chp_id,chp_nom,chp_first_journee_numero,chp_last_journee_numero from km_championnat where chp_status='STARTED' order by chp_nom asc");
    if ( $championnats != NULL) {
	       foreach($championnats as $champ) {
               echo "<option value=\"{$champ[0]}\">{$champ[1]} de J{$champ[2]} à J{$champ[3]}</option>";
           }
    }
?>
</select> du <input type="text" id="mercatoD_datepicker"
	name="mercatoFrom"> au <input type="text" id="mercatoF_datepicker"
	name="mercatoTo"> Heure <input name="mercatoTime" size="4"
	maxlength="2" />:00 <input type="submit" value="créer" /></p>
</form>
</div>
<div id="tabs-3">
<h2>Lancer un championnat</h2>
<form method="POST" action="process/createChampionnat.php">
<p>Franchises : <select multiple name='franchises[]' size='20'>
<?php
$franchisesQ = "select fra_id,fra_nom from km_franchise order by fra_nom asc";
$franchises = $db->getArray($franchisesQ);
if ($franchises != NULL) {
	foreach ($franchises as $value) {
		$frId = $value['fra_id'];
		$frNom = $value['fra_nom'];
		echo "<option value='{$frId}'";
		echo ">{$frNom}</option>";
	}
}
?>
</select> Nom:<input name="nom" /> Numéro première J <input
	name="jStart"  size="2" maxlength="2"/> ; Numéro dernière J <input name="jEnd" size="2" maxlength="2" />
<input type="submit" value="creer" /></p>
</form>
<h2>Rattacher des franchises à un championnat existant</h2>
<form action="process/attachChampionnat.php" method="post">
<p>Rattacher les franchises <select multiple name='franchises[]' size='5'>
<?php
$franchisesQ = "select fra_id,fra_nom from km_franchise left outer join km_inscription on ins_franchise_id=fra_id left outer join km_championnat on ins_championnat_id=chp_id where (ins_championnat_id is null or chp_status in ('FINISHED','CANCELLED','ABORTED') )order by fra_nom asc";
$franchises = $db->getArray($franchisesQ);
if ($franchises != NULL) {
foreach ($franchises as $value) {
		$frId = $value['fra_id'];
		$frNom = $value['fra_nom'];
		echo "<option value='{$frId}'";
		echo ">{$frNom}</option>";
	}
}
?>
</select> 
au championnat <select name='championnat'>
<?php
$champQ = "select chp_id,chp_nom,chp_first_journee_numero,chp_last_journee_numero from km_championnat where chp_status='CREATED' order by chp_nom asc";
$champ = $db->getArray($champQ);
if ($champ != NULL) {
	foreach ($champ as $value) {
		$chId = $value['chp_id'];
		$chNom = $value['chp_nom'];
		$firstJ = $value['chp_first_journee_numero'];
        $lastJ = $value['chp_last_journee_numero'];
		echo "<option value='{$chId}'";
		echo ">{$chNom} [de J{$firstJ} à J{$lastJ}]</option>";
	}
}
?>
</select> <input type="submit" value="associer"/></p>
</form>
</div>
    
    <div id="tabs-5">
    <h2>Mise à jour des championnats</h2>
    <form method="post" action="process/updateChampionnatsJournee.php">
    <p>Tous les championnats après la journée
                <select size=1 name="journee">
                    <?php
if ( $listJourneesQuery != NULL) {
	foreach($listJourneesQuery as $journee) {
		echo "<option value=\"{$journee[0]}\">{$journee[1]}</option>";
	}
}
                    ?>
                </select> 
                <input type="submit" value="par journée" /><b>Met à jour d'abord les sélections des titulaires</b></be></p>
            </form>
    <form method="post" action="process/updateChampionnat.php">
    <p>Toutes les journées du championnat 
                <select size=1 name="championnat">
                    <?php
if ( $listChampionnatsQuery != NULL) {
	foreach($listChampionnatsQuery as $champ) {
		echo "<option value=\"{$champ[0]}\">{$champ[1]} de J{$champ[2]} à J{$champ[3]}</option>";
	}
}
                    ?>
                </select> 
                <input type="submit" value="par championnat" /><b>Ne traite que les rounds où les selections ont été vérifiées. Donc utiliser le "par journée" dans le cas courant et réserver celui-ci au rattrapage.</b></p>
            </form>
    <h2>Cycle de vie des championnats</h2>
    <h3>Démarrer</h3>
    <form method="post" action="process/startChampionnat.php">
        <p>Démarrer le championnat <select size=1 name="championnat">
            <?php
    $championnats = $db->getArray("select chp_id,chp_nom,chp_first_journee_numero,chp_last_journee_numero from km_championnat where chp_status='CREATED' order by chp_nom asc");
        if ( $championnats != NULL) {
	       foreach($championnats as $champ) {
               echo "<option value=\"{$champ[0]}\">{$champ[1]} de J{$champ[2]} à J{$champ[3]}</option>";
           }
        }
            ?> </select> <input type="submit" value="demarrer" />
            (initialise le budget de chaque franchise)</p></form>
    <h3>Terminer</h3>
    <form method="post" action="process/stopChampionnat.php">
        <p>Terminer le championnat <select size=1 name="championnat">
            <?php
    $championnats = $db->getArray("select chp_id,chp_nom,chp_first_journee_numero,chp_last_journee_numero from km_championnat where chp_status='STARTED' order by chp_nom asc");
        if ( $championnats != NULL) {
	       foreach($championnats as $champ) {
               echo "<option value=\"{$champ[0]}\">{$champ[1]} de J{$champ[2]} à J{$champ[3]}</option>";
           }
        }
            ?> </select> <input type="submit" value="terminer" />
            (remplit le palmarès)</p></form>
</div>


</div>
</body>
</html>
