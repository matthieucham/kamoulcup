<?php
    include_once('../ctrl/rankingManager.php');
    include_once('../ctrl/journeeManager.php');
?>

<section id="championship">
    <h1>Championnat KDF</h1>
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
    $ranking = getRanking();
    $rank=1;
    foreach ($ranking as $r) {
        $sco = number_format(round($r['sumScore'],2),2);
        echo "<tr><td>{$rank}</td><td>{$r['nom']}</td><td>{$sco}</td></tr>";
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
        $ranking = getRankingJournee($lastJ['id']);
        $rank=1;
        foreach ($ranking as $r) {
            $sco = number_format(round($r['eks_score'],2),2);
            echo "<tr><td>{$rank}</td><td>{$r['nom']}</td><td>{$sco}</td></tr>";
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
<div id="compoPopup" class="popup hide">
<div class="cover"></div>
<div class="frame">
    <div id="compoContainer">
    <div id="dayScores">
        <h2>Journée <span>8</span> : <span>48.36</span> pts</h2>
        <div id="compo">
            <div id="compoG" class="compoPlayer">
                <p>Zacharie Boucher</p>
                <p><i class='fa fa-trophy'></i> 12.31 pts</p>
            </div>
            <div id="compoD1" class="compoPlayer">
                <p>Cédric Hengbart</p>
                <p><i class='fa fa-trophy'></i> 6.34 pts</p>
            </div>
            <div id="compoD2" class="compoPlayer">
                <p>Marquinhos</p>
                <p><i class='fa fa-trophy'></i> 10.12 pts</p>
            </div>
            <div id="compoM1" class="compoPlayer">
                <p>Maxime Gonalons</p>
                <p><i class='fa fa-trophy'></i> 7.58 pts</p>
            </div>
            <div id="compoM2" class="compoPlayer">
                <p>Lalïna Nomenjanahary</p>
                <p><i class='fa fa-trophy'></i> 2.01 pts</p>
            </div>
            <div id="compoA1" class="compoPlayer">
                <p>André-Pierre Gignac</p>
                <p><i class='fa fa-trophy'></i> 4.50 pts</p>
            </div>
            <div id="compoA2" class="compoPlayer">
                <p>Dario Cvitanich</p>
                <p><i class='fa fa-trophy'></i> 5.50 pts</p>
            </div>
        </div>
        <div id="bench">
            <h2>Banc de touche (0 pt)</h2>
            <ul>
                <li class="benchPlayer">
                    <p>Jean-Christophe Bahebeck</p>
                    <p><i class='fa fa-trophy'></i> 5.50 pts</p>
                </li>
                <li class="benchPlayer">
                    <p>Fabien Robert</p>
                    <p><i class='fa fa-trophy'></i> 1.00 pts</p>
                </li>
            </ul>
        </div>
    </div>
    <div id="daysList">
        <ul>
            <li>Journée 1 : 504.12 pts</li>
            <li>Journée 2 : 478.32 pts</li>
            <li>Journée 3 : 552.60 pts</li>
            <li>Journée 4 : 328.56 pts</li>
            <li>Journée 5 : 441.50 pts</li>
        </ul>
    </div>
</div>
</div>
</div>
</section>