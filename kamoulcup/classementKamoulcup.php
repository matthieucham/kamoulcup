<?php
function generateFullClassement($nomClassement,$scoreField) {
	global $db;
	echo "<div class='titre_page'>Classement {$nomClassement}</div>";
	$listPoulesQuery = $db->getArray("select id,nom from poule");
	foreach($listPoulesQuery as $poule) {
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>{$poule['nom']}</div>";
		echo "<table class='tableau_liste' cellpading='0' cellspacing='0'>";
		echo "<tr><th style='width:10px;'></th><th style='width:20px;'></th><th>Ekyp</th><th></th></tr>";
		$classQuery = $db->getArray("select id,nom,{$scoreField},complete from ekyp where poule_id={$poule['id']} order by complete desc, {$scoreField} desc");
		$i=0;
		if ($classQuery != NULL) {
			$lastScore = -1;
			foreach($classQuery as $ekyp) {
				$classNum = $i %2;
				$i++;
				$scoreFl = number_format(round(floatval($ekyp[$scoreField]),2),2);
				$rang = $i;
				if ($scoreFl == $lastScore) {
					$rang = '-';
				}
				$comp = $ekyp['complete'];
				$picto = 'images/stop.png';
				if ($comp) {
					$picto = 'images/accept.png';
				}
				echo "<tr class='ligne{$classNum}'><td style='width:10px;'>{$rang}</td><td style='width:20px;'><img src='{$picto}'/></td><td><a href=\"index.php?page=showEkyp&ekypid={$ekyp['id']}\">{$ekyp['nom']}</a></td><td align='right'>{$scoreFl}</td></tr>";
				$lastScore = $scoreFl;
			}
		}
		echo "</table></div>";
	}
}

generateFullClassement("Saison complète", "score");
echo "<br/>";
generateFullClassement("Apertura", "score1");
echo "<br/>";
generateFullClassement("Clausura", "score2");
?>


<?php
?>


