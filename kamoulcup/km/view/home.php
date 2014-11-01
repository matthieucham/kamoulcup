<?php
	include_once("../../vocabulaire.php");
    include_once("../ctrl/mercatoManager.php");
    include_once("../ctrl/journeeManager.php");
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
                $mercato = getCurrentMercato();
                if ($mercato != NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=market'> Mercato en cours ! Jusqu'au {$mercato['dateFermeture']}</a></li>";
                }
                $journee = getLastJournee();
                if ($journee != NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i><a href='#' linkCompo='../api/compos.php?franchiseid={$_SESSION['myEkypId']}&journeeid={$journee['id']}'> Mes derniers résultats</a></li>";
                }
                $nextJ = getNextJournee();
                if ($nextJ == NULL) {
                    echo "<li><i class='fa-li fa fa-info-circle'></i>Pas de journée prochainement programmée.</li>";
                } else {
                    $nextCompo = getCompoNoScore($_SESSION['myEkypId'],$nextJ['id'],true);
                    if ($nextCompo == NULL) {
                        echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=chooseTeam&journeeid={$nextJ['id']}'>Faire sa compo pour la journée {$nextJ['numero']} du {$nextJ['dateJournee']}.</a></li>";
                    } else {
                        echo "<li><i class='fa-li fa fa-info-circle'></i><a href='./index.php?kmpage=chooseTeam&journeeid={$nextJ['id']}'>Compo pour la journée {$nextJ['numero']} du {$nextJ['dateJournee']} enregistrée.</a></li>";
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