<?php
    include_once('../ctrl/franchiseManager.php');
    include_once('../ctrl/rankingManager.php');
    include_once('../ctrl/engagementManager.php');
    include_once('../ctrl/inscriptionManager.php');
    include_once('../ctrl/palmaresManager.php');
    include('fragments/franchisePositions.php');

    $franchiseId = $_GET['franchiseid'];
    $chpId = $_SESSION['myChampionnatId'];
    $inscription = getInscriptionFromChampionnat($franchiseId,$chpId);
    $inscriptionId = $inscription['ins_id'];
    $franchise = getFranchise($inscriptionId);
?>
<section id="otherTeam">
<h1><?php echo $franchise['fra_nom']?></h1>
<h2>En bref</h2>
<div id='team_overview'>
		<div class='overviewItem'>
			<p><i class='fa fa-male'></i> Contrats</p>
			<?php 
                displayPositions($inscriptionId);
            ?>
		</div>
		<div class='overviewItem'>
			<p><i class='fa fa-bank'></i> Budget</p>
			<p><span class='budgetValue'><?php echo number_format(floatval($franchise['fin_solde']),1).' Ka' ?></span></p>
		</div>
		<div class='overviewItem'>
			<p><i class='fa fa-pencil-square-o'></i> Masse salariale</p>
			<p><span class='budgetValue'><?php echo intval($franchise['masseSalariale']).' Ka' ?></span></p>
		</div>
		<div class='overviewItem'>
			<p><i class='fa fa-trophy'></i> Score</p>
			<p><span class='budgetValue'><?php echo number_format(getScoreFranchise($inscriptionId),2).' Pts' ?></span></p>
		</div>
</div>
<div id='team_scores'>
    <h2>Résultats</h2>
    <ul class='fa-ul'>
<?php
    $scores = getScoresHistorique($inscriptionId);
    if ($scores != NULL) {
        foreach($scores as $sc) {
            $score=number_format(round($sc['fsc_score'],2),2);
            echo "<li><i class='fa-li fa fa-trophy'></i><a href='#' linkCompo='../api/compos.php?franchiseid={$franchiseId}&roundid={$sc['cro_id']}'>Tour {$sc['cro_numero']} (L1 journée n°{$sc['numero']}) : {$score} Pts</a></li>";
        }
    }
?>
    </ul>
</div>
<div id='team_players'>
    <h2>Joueurs</h2>
<?php
    $contrats = getContrats($inscriptionId);

    echo "<table width='100%'>
	<thead>
	<tr>
		<th>Joueur</th><th>Poste</th><th>Prix d'achat</th><th>Salaire</th>
	</tr>
	</thead>
    <tbody>";
    if ($contrats != NULL) {
        foreach($contrats as $j) {
            $prix = number_format(round($j['eng_montant'],1),1);
            $sal = number_format(round($j['eng_salaire'],0),0);
            echo "<tr><td><a href='index.php?kmpage=home&page=detailJoueur&joueurid={$j['id']}'>{$j['prenom']} {$j['nomJoueur']} ({$j['nomClub']})</a></td><td>{$j['poste']}</td><td class='col_money'>{$prix} Ka</td><td class='col_money'>{$sal} Ka</td></tr>";
        }
    }
    echo "</tbody></table>";
?>
</div>
<?php include('fragments/compoPopup.php');?>
<div id='team_palmares'>
    <h2>Palmarès</h2>
<?php
    $palmares = getPalmares($franchiseId);
    if ($palmares == NULL) {
        echo "Néant";
    } else {
        echo "<ul class='fa-ul'>";
        foreach($palmares as $titre) {
            $iconSize = '4x';
            $colorClass= 'gold';
            if ($titre['pal_ranking']==2) {
                $iconSize='3x';
                $colorClass= 'silver';
            }
            if ($titre['pal_ranking']==3) {
                $iconSize='3x';
                $colorClass= 'bronze';
            }
            echo "<li><a href='index.php?kmpage=archivedChamp&champid={$titre['chp_id']}' title='{$titre['chp_nom']}'><i class='fa fa-trophy fa-{$iconSize} {$colorClass}'></i></a></li>";
        }
        echo "</ul>";
    }
?>
</div>
</section>
<script src="js/custom/km-otherTeam.js"></script>