<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('validateForm.php');

	$numero = correctSlash($_POST['numero']);
	
	valideInt($numero,'Numero','manageJournees');
	
	$date = correctSlash($_POST['date']);
	
	if ($_POST['nouveau']) {
		$saveJourneeQuery = "insert into journee(numero,date) values('{$numero}',str_to_date('{$date}','%Y-%m-%d'))";
	} else {
		$saveJourneeQuery = "update journee set numero='{$numero}', date=str_to_date('{$date}','%Y-%m-%d') where id='{$_POST['id']}'";
	}
	$db->query($saveJourneeQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=manageJournees');
	exit();
?>