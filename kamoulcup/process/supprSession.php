<?php
	include('checkAccess.php');
	checkAccess(4);
	include("../includes/db.php");
	
	// V�rification de la date pour chaque session. Si date_pas ant�rieure � 'now()', on n'autorise pas la suppression.
	$ids = $_POST['suppr'];
	foreach ($ids as $currId) {
		$checkDateSessionQuery = $db->getArray("select (now() > date_pas) from session where id='{$currId}' limit 1");
		if ($checkDateSessionQuery[0][0]) {
			$err = "Impossible de supprimer une session d�j� d�marr�e.";
			header('Location: ../index.php?page=manageSessions&ErrorMsg='.$err);
			exit();
		} else {
			$db->query("delete from session where id='{$currId}' limit 1");
		}
	}
	header('Location: ../index.php?page=manageSessions');
	exit();
?>
