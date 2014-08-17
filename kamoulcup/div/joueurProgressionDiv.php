<div class='sectionPage'>
<div class="sous_titre">Progression du joueur</div>
<?php
$journees = journee_list();
if (journees != NULL) {
	$progress = stats_listJoueur($joueurId);
	if ($progress != NULL) {
		$assocProg = Array();
		$assocProg1 = Array();
		$assocProg2 = Array();
		foreach($progress as $current) {
			$assocProg[$current['numero']] = $current['score'];
			$assocProg1[$current['numero']] = $current['score1'];
			$assocProg2[$current['numero']] = $current['score2'];
		}
		$lastScore=0;
		$lastScore=1;
		$lastScore=2;
		$indexJournee = 1;
		$resultArray = Array();
		$resultArray1 = Array();
		$resultArray2 = Array();
		//start the json data in the format Google Chart js/API expects to recieve it
		$JSONdata = "{
           \"cols\": [
               {\"label\":\"Journée\",\"type\":\"number\"},
               {\"label\":\"Score\",\"type\":\"number\"}
             ],
        \"rows\": [";

		foreach ($journees as $journee) {
			$numero = $journee['numero'];
			$JSONdata .= "{\"c\":[{\"v\": " . $numero . "}, {\"v\": ";
			if (isset($assocProg[$numero]) && $assocProg[$numero] != NULL) {
				$JSONdata .= $assocProg[$numero]  ."}]},";
				$resultArray[$numero]=$assocProg[$numero];
				$lastScore = $assocProg[$numero];
				$resultArray1[$numero]=$assocProg1[$numero];
				$lastScore1 = $assocProg1[$numero];
				$resultArray2[$numero]=$assocProg2[$numero];
				$lastScore2 = $assocProg2[$numero];
			} else {
				$resultArray[$numero]=$lastScore;
				$resultArray1[$numero]=$lastScore1;
				$resultArray2[$numero]=$lastScore2;
				$JSONdata .= $lastScore  ."}]},";
			}
		}
		//end the json data/object literal with the correct syntax
		$JSONdata .= "]}";

		// Set graph colors
		$color = array(
			'#99C754',
			'#54C7C5',
			'#999999',
		);
		/** Create chart */
		$chart = new GoogChart();
		$chart->setChartAttrs( array(
	'type' => 'line',
	'title' => 'Progression',
	'data' => array($resultArray,$resultArray1,$resultArray2),
	'size' => array( 400, 250 ),
	'color' => $color,
	'labelsXY' => true,
		'yRange' => 1.2*$lastScore, 'gridStep' => 10,
	'fill' => array( '#eeeeee', '#aaaaaa' ),
		));
		// Print chart
		echo $chart;

	}
}
?></div>
<div class='hr_feinte3'></div>
