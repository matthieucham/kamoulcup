<?php
function checkPlayerAccess() {
    session_start();
    $forbidden=false;
    if (!isset($_SESSION['myEkypId'])) {
        $forbidden=true;
		
	} else if (!isset($_SESSION['username'])) {
        $forbidden=true;
	} else if (!isset($_SESSION['km'])) {
        $forbidden=true;
	} else if (intval($_SESSION['km'])==0) {
        $forbidden=true;
	}
	if ($forbidden) {
        header('Location: ../forbidden.php');
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