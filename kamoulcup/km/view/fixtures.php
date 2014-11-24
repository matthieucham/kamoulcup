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

if ($champ['chp_status'] == CREATED) {
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
    $lastR = getLastProcessedRound($champId);
    if ($lastR != NULL ){
        echo "<div id='lastRound'><div id='teamsRanking'>";
        echo "<h2>Classement du dernier tour ({$lastR['cro_numero']})</h2>";
        echo "<table width='100%'>
	<thead>
	<tr>
		<th>Rang</th><th>Franchise</th><th>Score</th>
	</tr>
	</thead>
    <tbody>";
        $ranking = getRankingJournee($champId,$lastR['cro_id']);
        $rank=1;
        if ($ranking != NULL) {
        foreach ($ranking as $r) {
            $sco = number_format(round($r['fsc_score'],2),2);
            echo "<tr><td>{$rank}</td><td><a href='#' linkCompo='../api/compos.php?franchiseid={$r['fra_id']}&roundid={$lastR['cro_id']}'>{$r['fra_nom']}</a></td><td>{$sco}</td></tr>";
            $rank++;
        }
        }
        echo "</tbody>
	</table>
    </div>";
        echo "<div id='playersRanking'>";
        echo "<h2>Meilleurs joueurs</h2>";
        echo "<table width='100%'>
	<thead>
	<tr>
		<th>Rang</th><th>Nom</th><th>Salaire</th><th>Score</th><th>Franchise</th>
	</tr>
	</thead>
    <tbody>";
        $ranking = getRankingPlayersJournee($lastR['cro_id'],10);
        $rank=1;
        foreach ($ranking as $r) {
            $sco = number_format(round($r['jpe_score'],2),2);
            $sal = number_format(round($r['scl_salaire'],0),0);
            echo "<tr><td>{$rank}</td><td>{$r['prenom']} {$r['nomJoueur']}</td><td>{$sal} Ka</td><td>{$sco} Pts</td>";
            if ($r['nomEkyp'] == NULL) {
                echo "<td><i>libre</i></td>";
            } else {
                echo "<td>{$r['nomEkyp']}</td>";
            }
            echo "</tr>";
            $rank++;
        }
        echo "</tbody>
	</table>
    </div></div>";
    }
}
?>
<?php include('fragments/compoPopup.php');?>
</section>
<script src="js/custom/km-fixtures.js"></script>