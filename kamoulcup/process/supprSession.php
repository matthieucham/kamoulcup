<?php
	include('checkAccess.php');
	checkAccess(4);
	include("../includes/db.php");
	
	// Vérification de la date pour chaque session. Si date_pas antérieure à 'now()', on n'autorise pas la suppression.
	$ids = $_POST['suppr'];
	foreach ($ids as $currId) {
		$checkDateSessionQuery = $db->getArray("select (now() > date_pas) from session where id='{$currId}' limit 1");
		if ($checkDateSessionQuery[0][0]) {
			$err = "Impossible de supprimer une session déjà démarrée.";
			header('Location: ../index.php?page=manageSessions&ErrorMsg='.$err);
			exit();
		} else {
			$db->query("delete from session where id='{$currId}' limit 1");
		}
	}
	header('Location: ../index.php?page=manageSessions');
	exit();
?>
