<?php
function generateClassement($nomClassement, $scoreField) {
	global $db;
	echo "<div class='classement'><b>{$nomClassement}  </b><a href='index.php?page=classementKamoulcup'>[voir tout]</a>";
	$listPoulesQuery = $db->getArray("select id,nom from poule");
	foreach($listPoulesQuery as $poule) {
		echo "<table>";
		echo "<tr height='22px'><td colspan='10'><b>{$poule['nom']}</b></td></tr>";
		$classQuery = $db->getArray("select id,nom,{$scoreField},complete from ekyp where poule_id='{$poule['id']}' order by complete desc, {$scoreField} desc");
		$i=0;
		$lastScore = -1;
		$resumeDisplayed = false;
		if ($classQuery != NULL) {
			$nbEkyps = count($classQuery);
			foreach($classQuery as $ekyp) {
				$i++;
				//if ($i < 4 || $i> $nbEkyps-3)
				//{
				$scoreFl = number_format(round(floatval($ekyp[2]),2),2);
				$rang = $i;
				if ($scoreFl == $lastScore) {
					$rang = '-';
				}
				$comp = $ekyp['complete'];
				$picto = 'images/stop.png';
				if ($comp) {
					$picto = 'images/accept.png';
				}
				$lastScore = $scoreFl;
				echo "<tr height='22px'><td style='width:10px;'>{$rang}</td><td style='width:20px;'><img src='{$picto}'/></td><td colspan='7'><a href=\"index.php?page=showEkyp&ekypid={$ekyp['id']}\">{$ekyp['nom']}</a></td><td align='right'>{$scoreFl}</td></tr>";
				//				} else {
				//					if (! $resumeDisplayed ) {
				//						echo "<tr height='22px'><td colspan='10' align='center'> (...) </td></tr>";
				//						$resumeDisplayed = true;
				//					}
				//				}

			}
		}
		echo "</table><br/>";
	}
	echo "</div>";
}

//generateClassement("Apertura", "score1");
generateClassement("Classement Kamoulcup", "score");
//generateClassement("Clausura", "score2");
?>