<?php
session_start();

function checkAccess($minRight=1){
	if (!isset($_SESSION['userrights'])) {
		echo "<script>window.location.replace('index.php?page=forbidden&reason=needAuthentication');</script>";
		//header('Location: index.php?page=forbidden&reason=needAuthentication');
		exit();
	} else {
		if ($_SESSION['userrights']<$minRight) {
			//header('Location: index.php?page=forbidden&reason=unsufficientRights');
			echo "<script>window.location.replace('index.php?page=forbidden&reason=unsufficientRights');</script>";
			exit();
		}
	}
	return;
}


function checkEkyp() {
	if (!isset($_SESSION['myEkypId'])) {
		//header('Location: index.php?page=forbidden&reason=noEkypId');
		echo "<script>window.location.replace('index.php?page=forbidden&reason=noEkypId');</script>";
		exit();
	}
	if (!isset($_SESSION['pouleId'])) {
		//header('Location: index.php?page=forbidden&reason=noEkypId');
		echo "<script>window.location.replace('index.php?page=forbidden&reason=noEkypId');</script>";
		exit();
	}
}


// Si $maxDate == 0, non pris en compte.
function checkAccessDate($minDate,$maxDate) {
	if ($minDate > time()) {
		//header('Location: index.php?page=forbidden&reason=badTiming');
		echo "<script>window.location.replace('index.php?page=forbidden&reason=badTiming');</script>";
		exit();
	}
	if ($maxDate > 0) {
			if ($maxDate < time()) {
			//header('Location: index.php?page=forbidden&reason=badTiming');
			echo "<script>window.location.replace('index.php?page=forbidden&reason=badTiming');</script>";
			exit();
		}
	}
	return ;
}

?>