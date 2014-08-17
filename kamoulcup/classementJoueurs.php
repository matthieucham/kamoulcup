<div class='titre_page'>Classement des joueurs</div>
<?php
$listPoulesQuery = $db->getArray("select id, nom from poule order by nom asc");
?>
<form
	name="filterPouleForm" method="GET" action="index.php" />
<select name="scorefield" OnChange="document.filterPouleForm.submit()">
<?php
$scoreField = 'score';
if (isset($_GET['scorefield'])) {
	$scoreField =$_GET['scorefield'];
} else {
	$scoreField = 'score';
}
?>
	<option value="score"
	<?php if ($scoreField == 'score') {
		echo " selected";
	} ?>>Saison complète</option>
	<option value="score1"
	<?php if ($scoreField == 'score1') {
		echo " selected";
	} ?>>Apertura</option>
	<option value="score2"
	<?php if ($scoreField == 'score2') {
		echo " selected";
	} ?>>Clausura</option>
</select>
&nbsp;&nbsp;
<input
	type="hidden" name="page" value="classementJoueurs" />
<select name="pouleid" OnChange="document.filterPouleForm.submit()">
<?php
$pouleId = 0;
if (isset($_GET['pouleid'])) {
	$pouleId = intval($_GET['pouleid']);
} else {
	$pouleId = $listPoulesQuery[0]['id'];
}
foreach ($listPoulesQuery as $poule) {
	echo "<option value=\"{$poule['id']}\"";
	if ($pouleId == $poule['id']) {
		echo " selected";
	}
	echo ">{$poule['nom']}</option>";
}
?>
</select>

<noscript><input type="submit" value="go"></noscript>
</form>
<table class="tableau_liste">
	<tr>
		<th></th>
		<th>Joueur</th>
		<th>Poste</th>
		<th>Club</th>
		<th>Score</th>
		<th>Apertura</th>
		<th>Clausura</th>
		<th align='right' title='Indique les joueurs libres de cette poule'></th>
	</tr>
	<?php
	function flattenArray($array)
	{
		$flatArray = array();
		foreach( $array as $subElement ) {
			if( is_array($subElement) )
			$flatArray = array_merge($flatArray, flattenArray($subElement));
			else
			$flatArray[] = $subElement;
		}
		return $flatArray;
	}

	$meilleursJoueursQuery = $db->getArray("select jo.id as joueurId,jo.nom as joueurNom,jo.prenom,jo.score,jo.poste, cl.id as clubId, cl.id_lequipe as clubLe, cl.nom as clubNom,jo.score1,jo.score2 from joueur as jo, club as cl where jo.club_id = cl.id order by jo.{$scoreField} desc ");
	// tableau de tous les joueurs transférés de la poule courante
	$transfertsQuery = $db->getArray("select joueur_id from transfert where poule_id={$pouleId} order by joueur_id asc");
	$transfertsJoueurId = array();
	if ($transfertsQuery != NULL) {
		$transfertsJoueurId = flattenArray($transfertsQuery);
	}
	$pictoCart = 'images/cart.png';
	$i=0;
	$lastScore = -1;
	foreach($meilleursJoueursQuery as $joueur) {
		$classNum = $i %2;
		$i++;
		$scoreFl = number_format(round(floatval($joueur['score']),2),2);
		$scoreFl1 = number_format(round(floatval($joueur['score1']),2),2);
		$scoreFl2 = number_format(round(floatval($joueur['score2']),2),2);
		$rang = $i;
		if ($scoreFl == $lastScore) {
			$rang = '-';
		}
		$poste = traduire($joueur['poste']);
		echo "<tr class='ligne{$classNum}'><td>{$rang}</td><td><a href=\"index.php?page=detailJoueur&joueurid={$joueur['joueurId']}\">{$joueur['prenom']} {$joueur['joueurNom']}</a></td><td>{$poste}</td><td><a href=\"index.php?page=detailClub&clubid={$joueur['clubId']}\">{$joueur['clubNom']}</a></td><td align='right'>{$scoreFl}</td><td align='right'>{$scoreFl1}</td><td align='right'>{$scoreFl2}</td>";
		if (! in_array($joueur['joueurId'],$transfertsJoueurId)) {
			echo "<td align='center'><img src=\"{$pictoCart}\" title=\"Joueur libre\"/></td>";
		} else {
			echo "<td></td>";
		}
		echo "</tr>";
		$lastScore = $scoreFl;
	}
	?>
</table>

