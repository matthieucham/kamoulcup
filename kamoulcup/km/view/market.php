<?php
    if (isset($_SESSION['km']) && $_SESSION['km'] ) {
        $franchiseId = $_SESSION['myEkypId'];
    } else {
        echo "Erreur, pas de franchiseId";
        die();
    }
    include_once("../ctrl/franchiseManager.php");
    include_once("../ctrl/mercatoManager.php");
    include('fragments/franchisePositions.php');

// Init constants.
    $maxSalary=$KM_maxSalary;
    $maxPlayers=$KM_maxPlayers;
    $nbG=0;
    $nbD=0;
    $nbM=0;
    $nbA=0;


    $merkato= getCurrentMercato();
    if ($merkato != NULL) {
        $merkatoId = $merkato['mer_id'];
    } else {
        echo "Erreur, pas de mercato en cours";
        die();
    }

    $ekyp=getFranchise($franchiseId);
    $sousContrat=getContratsFranchise($franchiseId);
    $salaires=floatval($ekyp['masseSalariale']);
?>
<section id="market">
<h1>Merkato</h1>
<div id="marketInfo" class="sectionInfo">
	<p><?php echo "<p>Enregistrez vos offres avant {$merkato['dateFermeture']}</p>" ?></p>
</div>
<div class='rightColumn'>
<div id="budgetInfo">
	<h2><?php echo $ekyp['nom'];?></h2>
	<div class='budgetInfo_line'>
		<div class='budgetItem'><p>Contrats</p></div>
		<div class='budgetItem'>
            <div class='budgetInfo_line'>
			<?php /*include('fragments/franchisePositions.php');*/
                displayPositions($_SESSION['myEkypId']);
            ?>
            </div>
		</div>
	</div>
	<div class='budgetInfo_line'>
		<div class='budgetItem'>
			<p>Budget</p>
			<p><span class='budgetValue'><?php echo number_format($ekyp['fin_solde'],1);?>&nbsp;Ka</span></p>
		</div>
		<div class='budgetItem'>
			<p>Masse salariale</p>
			<p><span class='budgetValue'><?php echo number_format($salaires,1);?>&nbsp;Ka</span></p>
		</div>
        <?php
            // For jquery vars init:
            echo "<input type='hidden' id='initBudgetValue' value='{$ekyp['fin_solde']}' />";
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
<div id='playersCart'>
	<h2>Mon panier</h2>
	<form id='cartForm'>
		<div id='cartContent' class='playersList'>
			<ul>
                <li class='placeholder'>Faites glisser vos choix ici</li>
			</ul>
		</div>
		<div id='cartValue'>
			<p>Masse salariale : <span></span> Ka [Maximum : <?php echo $maxSalary; ?> Ka]</p>
			<p>Budget transfert restant : <span></span> Ka</p>
		</div>
		<button id="sendCartBtn">Envoyer</button>
        <div id='pourquoi' class='hide'>
            <p>Pourquoi je ne peux pas cliquer sur envoyer ?</p>
            <ul class='fa-ul'>
                <li><i class='fa-li fa fa-info-circle'></i>Parce que la somme des offres dépasse ton budget</li>
                <li><i class='fa-li fa fa-info-circle'></i>Parce que les joueurs que tu as choisis font dépasser ton plafond de masse salariale</li>
                <li><i class='fa-li fa fa-info-circle'></i>Parce que tu n'as pas sélectionné assez de joueur : il te faut au moins de quoi remplir chaque spot libre de ta franchise (cf ronds blancs ci dessus)</li>
                <li><i class='fa-li fa fa-info-circle'></i>Parce que tu as sélectionné trop de joueurs. Le maximum autorisé dans l'effectif est de <?php echo $KM_maxPlayers; ?> joueurs.</li>
            </ul>
        </div>
        <div id='sendResult'>
            <div class='uppings hide'><p><i class="fa fa-thumbs-up fa-2x"></i> Offres enregistrées</p></div>
            <div class='downings hide'><p><i class="fa fa-warning fa-2x"></i> </p></div>
        </div>
	</form>
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


<div id="registerPopup" class="popup hide">
<div class="cover"></div>
<div class="frame">
    <p><i class="fa fa-spinner fa-spin"></i> Enregistrement...</p>
</div>
</div>
</section>
<script src="js/custom/km-market.js"></script>