<?php
function checkPlayerAccess() {
    session_start();
    $forbidden=false;
    if (!isset($_SESSION['myChampionnatId'])) {
        $forbidden=true;
		
	} else if (!isset($_SESSION['username'])) {
        $forbidden=true;
	} 
	if ($forbidden) {
        header('Location: ../index.php');
		die();
    }
	return;
}

function checkAdminAccess() {
    session_start();
    $forbidden=false;
    if (!isset($_SESSION['userrights'])) {
        $forbidden=true;
	} else if (intval($_SESSION['userrights'])<5) {
        $forbidden=true;
	}
	if ($forbidden) {
        header('Location: ../forbidden.php');
		die();
    }
	return;
}
?>