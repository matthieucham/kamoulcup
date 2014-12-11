<?php
    include_once('../ctrl/rankingManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/roundManager.php');

    $champId = $_GET['champid'];
    $champ = getChampionnat($champId);

echo "<section id='championship'>
    <h1>{$champ['chp_nom']}</h1>
    <p>Se déroulait de la journée {$champ['chp_first_journee_numero']} à la journée {$champ['chp_last_journee_numero']} de L1</p>";
echo "<div id='fixtures'>";
if ($champ['chp_status'] != 'FINISHED') {
    echo "Le championnat n'est pas fini";
} else {
echo "<h2>Classement final</h2>";
?>
	<table width="100%">
	<thead>
	<tr>
		<th>Rang</th><th>Franchise</th><th>Score</th>
	</tr>
	</thead>
    <tbody>
<?php
    $ranking = getRanking($champId);
    $rank=1;
    foreach ($ranking as $r) {
        $sco = number_format(round($r['sumScore'],2),2);
        echo "<tr><td>{$rank}</td><td>{$r['fra_nom']}</td><td>{$sco}</td></tr>";
        $rank++;
    }
?>
	</tbody>
	</table>
<?php } ?>
</div>