<?php
	include_once("../../vocabulaire.php");
    include_once("../ctrl/mercatoManager.php");
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
  			<li><a href="./index.php?kmpage=transfers"><i class="fa-li fa fa-info-circle"></i> Bilan du dernier merkato</a></li>
            <?php
                $mercato = getCurrentMercato();
                if ($mercato != NULL) {
                    //$mercatoDate = date_create($mercato['mer_date_fermeture']);
                    //$dateF = date_format($mercatoDate,'d-m-Y H:i');
                    echo "<li><a href='./index.php?kmpage=market'><i class='fa-li fa fa-info-circle'></i> Mercato en cours ! Jusqu'au {$mercato['dateFermeture']}</a></li>";
                }
            ?>   
  			<li><i class="fa-li fa fa-info-circle"></i> Mes derniers résultats</li>
  		</ul>
	</div>
	<div id="kmWrapper">
	<?php	
	if (isset($_GET['page'])) {
		$contenuPage = $_GET['page'];
		// On essaye par defaut d'inclure les pages du dossier surcharge, 
		// et en cas d'echec on inclus la page KCUP
		if ((include('surcharge/'.$contenuPage.'.php'))===false) {
			include('../../'.$contenuPage.'.php');
		}
	}
	?>
	</div>
</div>

</section>
<script src="js/custom/km-home.js"></script>