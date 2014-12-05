<?php
function displayTeamRanking($roundId) {
        global $db;
        $round = getRoundInfo($roundId);
        echo "<h2>Classement du tour {$round['cro_numero']}</h2>";
        echo "<table width='100%'>
	<thead>
	<tr>
		<th>Rang</th><th>Franchise</th><th>Score</th>
	</tr>
	</thead>
    <tbody>";
        $ranking = getRankingJournee($round['cro_championnat_id'],$round['cro_id']);
        $rank=1;
        if ($ranking != NULL) {
        foreach ($ranking as $r) {
            $sco = number_format(round($r['fsc_score'],2),2);
            echo "<tr><td>{$rank}</td><td><a href='#' linkCompo='../api/compos.php?franchiseid={$r['fra_id']}&roundid={$roundId}'>{$r['fra_nom']}</a></td><td>{$sco}</td></tr>";
            $rank++;
        }
        }
        echo "</tbody>
	</table>";
}

function displayPlayerRanking($roundId) {
    global $db;
    $round = getRoundInfo($roundId);
    echo "<h2>Top 10 du tour</h2>";
        echo "<table width='100%'>
	<thead>
	<tr>
		<th>Rang</th><th>Nom</th><th>Salaire</th><th>Score</th><th>Franchise</th>
	</tr>
	</thead>
    <tbody>";
        $ranking = getRankingPlayersJournee($round['cro_id'],10);
        $rank=1;
        foreach ($ranking as $r) {
            $sco = number_format(round($r['jpe_score'],2),2);
            $sal = number_format(round($r['scl_salaire'],0),0);
            echo "<tr><td>{$rank}</td><td><a href='index.php?kmpage=home&page=detailJoueur&joueurid={$r['id']}'>{$r['prenom']} {$r['nomJoueur']}</a></td><td>{$sal} Ka</td><td>{$sco} Pts</td>";
            if ($r['nomEkyp'] == NULL) {
                echo "<td><i>libre</i></td>";
            } else {
                echo "<td>{$r['nomEkyp']}</td>";
            }
            echo "</tr>";
            $rank++;
        }
        echo "</tbody>
	</table>";
}
?>