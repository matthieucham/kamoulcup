<div class='titre_page'>Palmarès</div>

	<?php
		$listPalmaresQuery = $db->getArray("select trophee,nom_premier,score_premier,effectif_premier,nom_deuxieme,score_deuxieme,effectif_deuxieme,nom_troisieme,score_troisieme,effectif_troisieme from palmares order by date_enregistrement desc");
		if ($listPalmaresQuery != NULL) {
		foreach($listPalmaresQuery as $palmares) {
			echo "<div class='sectionPage'>";
			echo "<div class='sous_titre'>{$palmares['trophee']}</div>";
			$scor1 = number_format(round($palmares['score_premier'],2),2);
			$scor2 = number_format(round($palmares['score_deuxieme'],2),2);
			$scor3 = number_format(round($palmares['score_troisieme'],2),2);
			echo "<p><span class='palm1'>1: {$palmares['nom_premier']} {$scor1} points</span></p><p>{$palmares['effectif_premier']}</p>";
			echo "<br/>";
			echo "<p><span class='palm2'>2: {$palmares['nom_deuxieme']} {$scor2} points</span></p><p>{$palmares['effectif_deuxieme']}</p>";
			echo "<br/>";
			echo "<p><span class='palm3'>3: {$palmares['nom_troisieme']} {$scor3} points</span></p><p>{$palmares['effectif_troisieme']}</p>";
			echo "<br/>";
			echo "</div>";
		}
	}
	?>


