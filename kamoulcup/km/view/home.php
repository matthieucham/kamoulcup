<?php
	include("../../includes/db.php");
	include("../../vocabulaire.php");
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
  			<li><i class="fa-li fa fa-info-circle"></i> Bilan du dernier merkato</li>
  			<li><i class="fa-li fa fa-info-circle"></i> Merkato en cours ! Jusqu'au 15/10 20:00</li>
  			<li><i class="fa-li fa fa-info-circle"></i> Mes derniers résultats</li>
  		</ul>
	</div>
	<div id="kmWrapper">
	<?php	
	if (isset($_GET['page'])) {
		$contenuPage = $_GET['page'];
		// On essaye par defaut d'inclure les pages du dossier surcharge, 
		// et en cas d'echec on inclus la page KCUP
		if ((@include('surcharge/'.$contenuPage.'.php'))===false) {
			include('../../'.$contenuPage.'.php');
		}
	}
	?>
	</div>
</div>

</section>
<script src="js/custom/km-home.js"></script>