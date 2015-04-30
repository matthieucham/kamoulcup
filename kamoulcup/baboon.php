<?php
	checkaccess(1);
	$rights = $_SESSION['userrights'];
	echo "<div class='titre_page'>Baboon's corner</div>";
	echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>Profil</div>";
		echo "<div class='sectionContent'>";
		echo "<ul><li><a href='index.php?page=editPassword'>Changer de mot de passe</a></li></ul>";
		echo "</div>";
		echo "</div>";
	if ($rights > 1) {
		// Menu "Noteur"
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>Notation</div>";
		echo "<div class='sectionContent'>";
		echo "<ul><li><a href='index.php?page=manageJournees'>Saisir les notes</a></li></ul>";
		echo "</div>";
		echo "</div>";
	}
	
	if ($rights > 2) {
		// Menu "Créateur"
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>Création de données</div>";
		echo "<div class='sectionContent'>";
		echo "<ul>";
		echo "<li><a href='index.php?page=manageClubs'>Editer les clubs</a></li>";
		echo "<li><a href='index.php?page=manageJoueurs'>Créer un joueur</a></li>";
		echo "</ul>";
		echo "</div>";
		echo "</div>";
	}
	
	if ($rights > 3) {
		// Menu "Administration"
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>Organisation du jeu</div>";
		echo "<div class='sectionContent'>";
		echo "<ul>";
		echo "<li><a href='index.php?page=managePeriodes'>Gérer les périodes de vente</a></li>";
		echo "<li><a href='index.php?page=resoudre'>Résoudre les enchères</a></li>";
		echo "<li><a href='index.php?page=managePalmares'>Gerer le palmarès</a></li>";
		echo "<li><a href='index.php?page=manageBonus'>Gérer les bonus</a></li>";
		echo "<li><a href='index.php?page=draft'>Attribuer les choix de draft</a></li>";
		echo "</ul>";
		echo "</div>";
		echo "</div>";
	}
	
	if ($rights > 4) {
		// Menu "super admin"
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>Administration</div>";
		echo "<div class='sectionContent'>";
		echo "<ul>";
		echo "<li><a href='index.php?page=managePoules'>Gérer les poules</a></li>";
		echo "<li><a href='index.php?page=manageEkyps'>Gérer les ékyps</a></li>";
		echo "<li><a href='process/calculScores.php'>Recalculer les scores</a></li>";
		echo "<li><a href='process/updatePrestations.php'>Mettre à jour les prestations</a></li>";
		echo "<li><a href='index.php?page=asEkyp'>Prendre le contrôle temporaire d'une ékyp</a></li>";
		echo "<li><a href='process/generateFeeds.php'>Genérer tous les feeds de résolution</a></li>";
		echo "<li><a href='mobilecom/getResolutionsFeed.php'>GET Feeds</a></li>";
		echo "<li><a href='km/admin/index.php'>KAMOUL MANAGER ADMIN</a></li>";
		echo "<li><a href='process/initImport.php'>Importer les résultats</a></li>";
		echo "</ul>";
		echo "</div>";
		echo "</div>";
	}
?>

