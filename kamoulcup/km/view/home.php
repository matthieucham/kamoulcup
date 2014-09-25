<section id="home">
<div id="realData">

	<div id="kmWrapper">
	<?php
	include("../../includes/db.php");
	include("../../vocabulaire.php");
	// pour tester l'integration, lister les clubs comme point d'entree
	$clubsQ = "select id,nom from club order by nom asc";
	$clubs = $db->getArray($clubsQ);
	echo "<p>";
	foreach ($clubs as $club) {
		echo "<a href='index.php?page=detailClub&clubid={$club['id']}'>{$club['nom']} </a>";
	}
	echo "</p>";
	
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
	<div id="lastResults">
	<?php
		 include("fragments/lastResults.php");
	?>
	</div>
</div>

</section>