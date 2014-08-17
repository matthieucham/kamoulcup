<?php
	include('checkAccess.php');
	checkAccess(4);
	include("../includes/db.php");
	include('validateForm.php');

	
	$delai = correctSlash($_POST['delaiEncheres']);
	valideInt($delai,'delaiEncheres','managePeriodes');
	
	$dateDebut = htmlspecialchars(correctSlash($_POST['dateDebut']), ENT_COMPAT, 'UTF-8');
	valideString($dateDebut,'Date début','managePeriodes');
	
	$dateFin = htmlspecialchars(correctSlash($_POST['dateFin']), ENT_COMPAT, 'UTF-8');
	valideString($dateFin,'Date de fin','managePeriodes');
	
	$coeff = correctSlash($_POST['coeffAchat']);
	valideFloat($coeff,'coeffAchat','managePeriodes');
	
	$poule = correctSlash($_POST['poule']);
	valideInt($poule,'poule','managePeriodes');
	
	$savePeriodeQuery = "insert into periode(date_debut,date_fin,delai_encheres,reventes_autorisees,coeff_bonus_achat,poule_id,draft) values(str_to_date('{$dateDebut}','%Y-%m-%d %H:%i:%s'),str_to_date('{$dateFin}','%Y-%m-%d %H:%i:%s'),{$delai},{$_POST['revente']},{$coeff},{$poule},{$_POST['draft']})";
	
	$db->query($savePeriodeQuery) or die('Error, insert query failed, see log');
	
	header('Location: ../index.php?page=managePeriodes');
	exit();
?>