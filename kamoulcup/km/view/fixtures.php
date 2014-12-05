<?php
    include_once('../ctrl/rankingManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/roundManager.php');

    $champId = $_SESSION['myChampionnatId'];
    $champ = getChampionnat($champId);

echo "<section id='championship'>
    <h1>{$champ['chp_nom']}</h1>
    <p>Se déroule de la journée {$champ['chp_first_journee_numero']} à la journée {$champ['chp_last_journee_numero']} de L1</p>";
    $nbTours = $champ['chp_last_journee_numero'] - $champ['chp_first_journee_numero'] +1;
    $indexJournee = $champ['nbPlayed'].'/'.$nbTours;
echo "<div id='fixtures'>";

if ($champ['chp_status'] == 'CREATED') {
    echo "<p>Le championnat débutera prochainement</p>";
} else {

echo "<h2>Classement Général après le tour {$indexJournee}</h2>";
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
        echo "<tr><td>{$rank}</td><td><a href='index.php?kmpage=otherTeam&franchiseid={$r['fra_id']}'>{$r['fra_nom']}</a></td><td>{$sco}</td></tr>";
        $rank++;
    }
?>
	</tbody>
	</table>
</div>
<?php
    $rounds = getLastProcessedRounds($champId);
    //$lastR = getLastProcessedRound($champId);
    if ($rounds != NULL ){
        include_once('fragments/fixturesRound.php');
        echo "<h2>Classement par tour</h2>";
        echo "<p>";
        foreach ($rounds as $round) {
            echo "<a href='#' roundRanking='{$round['cro_id']}'>Tour {$round['cro_numero']}&nbsp;</a>";
        }
        echo "</p><div id='lastRound'><div id='teamsRanking'>";
        $lastR = $rounds[0];
        displayTeamRanking($lastR['cro_id']);
        echo "</div>";
        echo "<div id='playersRanking'>";
        displayPlayerRanking($lastR['cro_id']);
        echo "
    </div></div>";
    }
}
?>
<?php include('fragments/compoPopup.php');?>
</section>
<script src="js/custom/km-fixtures.js"></script>