<?php
	include_once("../../vocabulaire.php");
    include_once("../ctrl/mercatoManager.php");
    include_once("../ctrl/journeeManager.php");
    include_once("../ctrl/roundManager.php");
    include_once("../ctrl/compoManager.php");
?>
<section id="home">
<div id="realData">
	<div id="breadcrumb"></div>
	<h1>Les gros dossiers</h1>
	<div id="lastResults">
	<?php
		 include("fragments/lastResults.php");
	?>
	</div>
	<div id="news">
		<h2><i class="fa fa-inbox"></i> Dernières infos</h2>
		<ul class="fa-ul">
  			<li><i class="fa-li fa fa-info-circle"></i><a href="./index.php?kmpage=transfers"> Bilan du dernier merkato</a></li>
            <?php
                $mercato = getCurrentMercato($_SESSION['myChampionnatId']);
                if ($mercato != NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=market'> Mercato en cours ! Jusqu'au {$mercato['dateFermeture']}</a></li>";
                }
                $round = getLastProcessedRound($_SESSION['myChampionnatId']);
                if ($round != NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i><a href='#' linkCompo='../api/compos.php?franchiseid={$_SESSION['myFranchiseId']}&roundid={$round['cro_id']}'> Résultats du tour {$round['cro_numero']} (Ligue 1 journée n°{$round['numero']} du {$round['dateJournee']})</a></li>";
                } else {
                    echo "<li><i class='fa-li fa fa-info-circle'></i> Pas encore de résultats à afficher</li>";
                }
                $nextRound = getNextRoundToPlay($_SESSION['myChampionnatId']);
                if ($nextRound == NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i>Pas de tour prochainement programmé.</li>";
                } else {
                    $nextCompo = getSelectedCompo($_SESSION['myFranchiseId'],$nextRound['cro_id'],true);
                    if ($nextCompo == NULL) {
                        echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=chooseTeam&roundid={$nextRound['cro_id']}'>Faire sa compo pour le tour {$nextRound['cro_numero']} (L1 journée n°{$nextRound['numero']} du {$nextRound['dateJournee']})</a></li>";
                    } else {
                        echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=chooseTeam&roundid={$nextRound['cro_id']}'>Compo pour le tour {$nextRound['cro_numero']} (L1 journée n°{$nextRound['numero']} du {$nextRound['dateJournee']}) enregistrée.</a></li>";
                    }
                }
            ?>   
  			
  		</ul>
	</div>
	<div id="kmWrapper">
	<?php	
	if (isset($_GET['page'])) {
		$contenuPage = $_GET['page'];
        include('surcharge/'.$contenuPage.'.php');
		//// On essaye par defaut d'inclure les pages du dossier surcharge, 
		//// et en cas d'echec on inclus la page KCUP
		//if ((include('surcharge/'.$contenuPage.'.php'))===false) {
		//	include('../../'.$contenuPage.'.php');
		//}
	}
	?>
	</div>
</div>
<?php include('fragments/compoPopup.php');?>
</section>
<script src="js/custom/km-home.js"></script>