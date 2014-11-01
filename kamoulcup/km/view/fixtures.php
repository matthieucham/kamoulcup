<?php
    include_once('../ctrl/rankingManager.php');
    include_once('../ctrl/journeeManager.php');
    $champId = $_SESSION['champId'];
    $champ = getChampionnat($champId);

echo "<section id='championship'>
    <h1>{$champ['nom']}</h1>";
?>

<div id="fixtures">
	<h2>Classement Général</h2>
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
        echo "<tr><td>{$rank}</td><td><a href='index.php?kmpage=otherTeam&franchiseid={$r['id']}'>{$r['nom']}</a></td><td>{$sco}</td></tr>";
        $rank++;
    }
?>
	</tbody>
	</table>
</div>
<?php
    $lastJ = getLastJournee();
    if ($lastJ != NULL ){
        echo "<div id='lastRound'><div id='teamsRanking'>";
        echo "<h2>Dernière journée ({$lastJ['numero']})</h2>";
        echo "<table width='100%'>
	<thead>
	<tr>
		<th>Rang</th><th>Franchise</th><th>Score</th>
	</tr>
	</thead>
    <tbody>";
        $ranking = getRankingJournee($champId,$lastJ['id']);
        $rank=1;
        foreach ($ranking as $r) {
            $sco = number_format(round($r['eks_score'],2),2);
            echo "<tr><td>{$rank}</td><td><a href='#' linkCompo='../api/compos.php?franchiseid={$r['id']}&journeeid={$lastJ['id']}'>{$r['nom']}</a></td><td>{$sco}</td></tr>";
            $rank++;
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
        $ranking = getRankingPlayersJournee($lastJ['id'],10);
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
?>
<?php include('fragments/compoPopup.php');?>
</section>
<script src="js/custom/km-fixtures.js"></script>