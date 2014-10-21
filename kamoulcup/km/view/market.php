<?php
    if (isset($_SESSION['km']) && $_SESSION['km'] ) {
        $franchiseId = $_SESSION['myEkypId'];
    } else {
        echo "Erreur, pas de franchiseId";
        die();
    }

// Init constants.
    $maxSalary=$KM_maxSalary;
    $maxPlayers=$KM_maxPlayers;
    $nbG=0;
    $nbD=0;
    $nbM=0;
    $nbA=0;

    $merkatoQ="select mer_id from km_mercato where mer_date_ouverture<now() and mer_date_fermeture>now() and mer_processed=0 limit 1";
    $merkato=$db->getArray($merkatoQ);
    if ($merkato != NULL) {
        $merkatoId = $merkato[0][0];
    } else {
        echo "Erreur, pas de mercato en cours";
        die();
    }
    $ekypQ="select nom,fin_solde from ekyp inner join km_finances on fin_ekyp_id=id where id={$franchiseId} order by fin_id desc limit 1";
    $sousContratQ="select id,prenom,nom,poste,eng_salaire from joueur inner join km_engagement on id=eng_joueur_id where eng_ekyp_id={$franchiseId} and eng_date_depart is null";

    $ekyp=$db->getArray($ekypQ);
    $sousContrat = $db->getArray($sousContratQ);
    $salaires=0;
    if ($sousContrat != NULL) {
    	foreach ($sousContrat as $contrat) {
    		$salaires += intval($contrat['eng_salaire']);
    	}
    }
?>
<section id="market">
<h1>Merkato</h1>
<div id="marketInfo" class="sectionInfo">
	<p>Marché ouvert du 17/11 au 19/11</p>
</div>
<div id="budgetInfo">
	<h2><?php echo $ekyp[0]['nom'];?></h2>
	<div class='budgetInfo_line'>
		<div class='budgetItem'><p>Contrats</p></div>
		<div class='budgetItem'>
			<div class='contract_positions_container'>
			<?php
				$position = array();
				$position['G']=NULL;
				$position['D1']=NULL;
				$position['D2']=NULL;
				$position['M1']=NULL;
				$position['M2']=NULL;
				$position['A1']=NULL;
				$position['A2']=NULL;
				if ($salaires > 0) { // manière rapide de savoir s'il y a des joueurs dans cette équipe
					foreach ($sousContrat as $contrat) {
						if ($contrat['poste']=='G') {
							if ($position['G']==NULL) {
								$position['G']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbG++;
						}
						if ($contrat['poste']=='D') {
							if ($position['D1']==NULL) {
								$position['D1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['D2']==NULL) {
								$position['D2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbD++;
						}
						if ($contrat['poste']=='M') {
							if ($position['M1']==NULL) {
								$position['M1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['M2']==NULL) {
								$position['M2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbM++;
						}
						if ($contrat['poste']=='A') {
							if ($position['A1']==NULL) {
								$position['A1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['A2']==NULL) {
								$position['A2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbA++;
						}
					}
				}
				echoPosition($position, 'G', 'G');
				echoPosition($position, 'D', 'D1');
				echoPosition($position, 'D', 'D2');
				echoPosition($position, 'M', 'M1');
				echoPosition($position, 'M', 'M2');
				echoPosition($position, 'A', 'A1');
				echoPosition($position, 'A', 'A2');
			?>
		</div>
		</div>
	</div>
	<div class='budgetInfo_line'>
		<div class='budgetItem'>
			<p>Budget</p>
			<p><span class='budgetValue'><?php echo number_format($ekyp[0]['fin_solde'],1);?>&nbsp;Ka</span></p>
		</div>
		<div class='budgetItem'>
			<p>Masse salariale</p>
			<p><span class='budgetValue'><?php echo number_format($salaires,1);?>&nbsp;Ka</span></p>
		</div>
        <?php
            // For jquery vars init:
            echo "<input type='hidden' id='initBudgetValue' value='{$ekyp[0]['fin_solde']}' />";
            echo "<input type='hidden' id='initSalaryValue' value='{$salaires}' />";
            echo "<input type='hidden' id='maxSalary' value='{$maxSalary}' />";
            $pl = $maxPlayers-($nbG+$nbD+$nbM+$nbA);
            echo "<input type='hidden' id='maxPlayers' value='{$pl}' />";
            $g = $KM_minG-$nbG;
            $d= $KM_minD-$nbD;
            $m=$KM_minM-$nbM;
            $a=$KM_minA-$nbA;
            echo "<input type='hidden' id='nbMinG' value='{$g}' />";
            echo "<input type='hidden' id='nbMinD' value='{$d}' />";
            echo "<input type='hidden' id='nbMinM' value='{$m}' />";
            echo "<input type='hidden' id='nbMinA' value='{$a}' />";
        ?>
	</div>
</div>
<div id='clubPlayersList'>
		<p><label for='clubSelect'>Club</label>
		<select id='clubSelect'></select></p>
	
	<div id='playersList_effectif' class='playersList'>
		<h2 id='selectedClubName'></h2>
		<ul id='playersList_list'>
		</ul>
	</div>
</div>
<div id='playersCart'>
	<h2>Mon panier</h2>
	<form id='cartForm'>
		<div id='cartContent' class='playersList'>
			<ul>
                <li class='placeholder'>Faites glisser vos choix ici</li>
			</ul>
		</div>
		<div id='cartValue'>
			<p>Masse salariale : <span></span> Ka [Maximum : <?php echo $maxSalary; ?> Ka</p>
			<p>Budget transfert restant : <span></span> Ka</p>
		</div>
		<button id="sendCartBtn">Envoyer</button>
	</form>
</div>
</section>
<script src="js/custom/km-market.js"></script>

<?php 
	function echoPosition($positionArray,$targetPos,$targetSpot) {
		echo "<div class='contract_position'>{$targetPos}<div class='pos_marker";
		if ($positionArray[$targetSpot] == NULL) {
		 	echo " pos_marker_empty'";
		} else {
			echo " pos_marker_filled' title='{$positionArray[$targetSpot]}'";
		}
		echo "></div></div>";
	}
?>