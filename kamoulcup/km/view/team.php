<?php
    include_once('../ctrl/franchiseManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/joueurManager.php');
    include_once('../ctrl/transferManager.php');
    include_once('../ctrl/mercatoManager.php');
    include('fragments/franchisePositions.php'); 
    $franchise = getFranchise($_SESSION['myInscriptionId']);
?>
<section id="team">
<h1><?php echo $franchise['fra_nom']?></h1>
<h2>En bref</h2>
<div id='team_overview'>
		<div class='overviewItem'>
			<p><i class='fa fa-male'></i> Contrats</p>
			<?php /*include('fragments/franchisePositions.php');*/
                displayPositions($_SESSION['myInscriptionId']);
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
			<p><span class='budgetValue'><?php echo number_format(getScoreFranchise($_SESSION['myInscriptionId']),2).' Pts' ?></span></p>
		</div>
</div>

<div id='team_players'>
	<h2>Effectif sous contrat</h2>
    <div id="dialog-confirm"></div>
    <?php
        $currentMercato = getCurrentMercato($_SESSION['myChampionnatId']);
        $mercatoEnCours = $currentMercato != NULL;
        $players = getContratsFranchise($_SESSION['myInscriptionId']);
    if ($players == NULL) {
        echo "Pas de joueurs sous contrat";
    } else {
        echo "<ul>";
        $statsJournees = getLastNJournees(3);
        foreach ($players as $player) {
            $stats = getJoueurStats($player['id'],$statsJournees);
            $joueurInfos = getJoueurCommonInfo($player['id']);
            echo "<li class='team_player_container'>
            <div class='team_player_tab realPlayerInfo'>
				<h4><a href='./index.php?kmpage=home&page=detailJoueur&joueurid={$player['id']}'>{$player['prenom']} {$player['nom']}</a></h4>
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
				<ul>";
            $sal = number_format($player['eng_salaire'],0);
            $realSal = number_format($joueurInfos['scl_salaire'],0);
			echo "<li class='vignette' title='Salaire'><i class='fa fa-pencil-square-o'></i><span class='main'>{$sal} Ka</span><span class='annex'>virtuel : {$realSal} Ka</span></li>";
            $statsF = getStatsFranchiseJoueur($_SESSION['myInscriptionId'],$player['id']);
            $score = number_format(round($statsF[0],2),2);
            $nbJournees = $statsF[1];
			echo "<li class='vignette' title='Points rapportés'><i class='fa fa-trophy'></i><span class='main'>{$score} pts</span><span class='annex'>en {$nbJournees} tours</span></li>";
            $transfer = getLastTransfer($player['id'],$_SESSION['myChampionnatId']);
            $montant = number_format(round($transfer['eng_montant'],1),1);
			echo "<li class='vignette' title='Prix achat'><i class='fa fa-shopping-cart'></i><span class='main'>{$montant} Ka</span><span class='annex'>{$transfer['dateArrivee']}</span></li>
				</ul>
				</div>";
            echo "<div class='teamPlayerInfo_action'>";
            $isListed=false;
            if ($player['ltr_montant'] != NULL) {
                $trMontant = number_format(round($player['ltr_montant'],1),1);
                $isListed=true;
                echo "<p><span class='vignette' title='Sur la liste des transferts'><i class='fa fa-money'></i><span class='main'>{$trMontant} Ka</span><span class='annex'>En vente</span></span></p>";
            }
            if (! ($isListed && $mercatoEnCours)) {
                echo "<a href='#' class='transferList_handle'><i class='fa fa-toggle-down'></i> Actions</a>
					<div class='transferList_actions'>";
                echo "<form method='post' action='../ctrl/firePlayer.php' id='form-fire-{$player['id']}'>
							<input type='hidden' name='playerid' value='{$player['id']}' />
                            <input type='hidden' name='playername' value='{$player['prenom']} {$player['nom']}' />
							<button>Libérer (0 Ka)</button>
						</form>
						<hr/>";
                if ($isListed) {
                    echo "<form method='post' action='../ctrl/unlistPlayer.php' id='form-unlist-{$player['id']}'>
							<input type='hidden' name='playerid' value='{$player['id']}' />
                            <input type='hidden' name='playername' value='{$player['prenom']} {$player['nom']}' />
							<button>Retirer de la liste</button>
						</form>";
                } else if (!$mercatoEnCours) {
				    echo "<form method='post' action='../ctrl/listPlayer.php' id='form-list-{$player['id']}'>
							<input type='hidden' name='playerid' value='{$player['id']}' />
                            <input type='hidden' name='playername' value='{$player['prenom']} {$player['nom']}' />
							<p><label for='sellValue{$player['id']}'>Mettre en vente à </label>
							<input type='text' name='sellValue[{$player['id']}]' id='sellValue{$player['id']}' class='sellPrice_input' style='width:40px' maxLength='4' value='0.1'/>
							Ka</p>
							<button>Lister</button>
						</form>";
                }
            echo "</div>";
            }
			echo "
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
    <?php include_once('../ctrl/financesManager.php');?>
<table width="100%">
	<thead>
	<tr>
		<th>Date</th><th>Evènement</th><th>Crédit</th><th>Débit</th><th>Solde</th>
	</tr>
	</thead>
	<tbody>
    <?php
    $finances = getFinances($_SESSION['myInscriptionId']);
    if ($finances != NULL) {
        foreach($finances as $evt) {
            echo "<tr>
                <td>{$evt['dateEvenement']}</td><td>{$evt['fin_event']}</td>";
            $montantTransaction = number_format(round($evt['fin_transaction'],1),1);
            $solde = number_format(round($evt['fin_solde'],1),1);
            if ($evt['fin_transaction']>=0) {
                echo"<td class='col_money'>+{$montantTransaction} Ka</td><td class='col_money'></td>";
            } else {
                echo"<td class='col_money'></td><td class='col_money'>{$montantTransaction} Ka</td>";
            }
            echo "<td  class='col_money'>{$solde} Ka</td>";
            echo "</tr>";
        }
    } ?>
	</tbody>
</table>
</div>



</section>
<script src="js/custom/km-team.js"></script>