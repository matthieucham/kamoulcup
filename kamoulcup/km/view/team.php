<?php
    include_once('../ctrl/franchiseManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/joueurManager.php');
    $franchise = getFranchise($_SESSION['myEkypId']);
?>
<section id="team">
<h1><?php echo $franchise['nom']?></h1>
<h2>En bref</h2>
<div id='team_overview'>
		<div class='overviewItem'>
			<p><i class='fa fa-male'></i> Contrats</p>
			<?php include('fragments/franchisePositions.php'); ?>
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
			<p><span class='budgetValue'><?php echo number_format(getScoreFranchise($_SESSION['myEkypId']),1).' Pts' ?></span></p>
		</div>
</div>

<div id='team_players'>
	<h2>Effectif sous contrat</h2>
    <?php
    $players = getContratsFranchise($_SESSION['myEkypId']);
    if (players == NULL) {
        echo "Pas de joueurs sous contrat";
    } else {
        echo "<ul>";
        $statsJournees = getLastNJournees(3);
        foreach ($players as $player) {
            $stats = getJoueurStats($player['id'],$statsJournees);
            echo "<li class='team_player_container'>
            <div class='team_player_tab realPlayerInfo'>
				<h4>{$player['prenom']} {$player['nom']}</h4>
				<p><span class='playerPosition'>{$player['poste']}</span> {$player['nomClub']}</p>
			</div>
			<div class='team_player_tab gamePlayerInfo'>
				<div class='playerStats'>
					<p><i class='fa fa-line-chart'></i></p>";
            $s1 = number_format(round(floatval($stats[0]),2),2);
            $s2 = number_format(round(floatval($stats[1]),2),2);
            $s3 = number_format(round(floatval($stats[2]),2),2);
            echo "<ul>
						<li class='stat' title='Dernier match'><span class='main emphasize'>{$s1} pts</span><span class='annex'>Dernier</span></li>
						<li class='stat' title='Moyenne des 3 derniers matchs'><span class='main'>{$s2} pts</span><span class='annex'>Moy. 3 matchs</span></li>
						<li class='stat' title='Moyenne sur toute la saison'><span class='main'>{$s3} pts</span><span class='annex'>Moyenne</span></li>
					</ul>
				</div>
			</div>
			
			<div class='team_player_tab teamPlayerInfo'>
				<div class='teamPlayerInfo_data'>
				<ul>
					<li class='vignette' title='Salaire'><i class='fa fa-pencil-square-o'></i><span class='main'>8 Ka</span><span class='annex'>virtuel : 12 Ka</span></li>
					<li class='vignette' title='Points rapportés'><i class='fa fa-trophy'></i><span class='main'>48.7 pts</span><span class='annex'>en 5 journées</span></li>
					<li class='vignette' title='Prix d''achat'><i class='fa fa-shopping-cart'></i><span class='main'>7.9 Ka</span><span class='annex'>02/09/2014</span></li>
				</ul>
				</div>
				<div class='teamPlayerInfo_action'>
					<p><span class='vignette' title='Sur la liste des transferts'><i class='fa fa-money'></i><span class='main'>10 Ka</span><span class='annex'>En vente</span></span></p>
					<a href='#' class='transferList_handle'><i class='fa fa-toggle-down'></i> Actions</a>
					<div class='transferList_actions'>
						<form method='post' id='firePlayerForm14785' action='#'>
							<input type='hidden' name='playerid' value='14785' />
							<button id='sendCartBtn'>Libérer (0 Ka)</button>
						</form>
						<hr/>
						<form method='post' id='sellPlayerForm14785' action='#'>
							<input type='hidden' name='playerid' value='14785' />
							<p><label for='sellValue14785'>Mettre en vente à </label>
							<input type='text' id='sellValue14785' class='sellPrice_input' style='width:40px' maxLength='4' />
							Ka</p>
							<p><button id='sendCartBtn'>Lister</button></p>
						</form>
						<hr/>
						<form method='post' id='unlistPlayerForm14785' action='#'>
							<input type='hidden' name='playerid' value='14785' />
							<button id='sendCartBtn'>Retirer de la liste</button>
						</form>
					</div>
				</div>
			</div>
		</li> <!-- End player view -->";
        }	
	echo "</ul>";
    }
?>
	
</div>


<h2>Finances</h2>
<div id="team_money">
<table width="100%">
	<thead>
	<tr>
		<th>Date</th><th>Evènement</th><th>Crédit</th><th>Débit</th><th>Solde</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>02/09/2014</td><td>Achat du joueur Mevlüt Erding</td><td></td><td  class="col_money">-7.9 Ka</td><td  class="col_money">82.1 Ka</td>
	</tr>
	<tr>
		<td>03/09/2014</td><td>Prime de redistribution</td><td class="col_money">+2.1 Ka</td><td></td><td  class="col_money">84.2 Ka</td>
	</tr>
	<tr>
		<td>08/09/2014</td><td>Revente du joueur Maxime Gonalons</td><td class="col_money">+14.1 Ka</td><td></td><td class="col_money">98.3 Ka</td>
	</tr>
	</tbody>
</table>
</div>



</section>
<script src="js/custom/km-team.js"></script>