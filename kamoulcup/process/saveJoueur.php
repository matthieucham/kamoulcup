<?php
	include('checkAccess.php');
	checkAccess(3);
	include("../includes/db.php");
	include('validateForm.php');

	$nom = htmlspecialchars(correctSlash($_POST['nom']), ENT_COMPAT, 'UTF-8');
	valideString($nom,'Nom','manageJoueurs');
	
	$prenom = htmlspecialchars(correctSlash($_POST['prenom']), ENT_COMPAT, 'UTF-8');
	
	$id_lequipe = htmlspecialchars(correctSlash($_POST['id_lequipe']), ENT_COMPAT, 'UTF-8');

	$position = htmlspecialchars(correctSlash($_POST['position']), ENT_COMPAT, 'UTF-8');
	
	$id_ws = intval($_POST['id_ws']);
	
	$clubId = correctSlash($_POST['club']);
	//valideString($clubId,'Club','manageJoueurs');
	if (strlen($clubId) == 0) {
		$clubId = 'NULL';
	}
	
	$joueurId = 0;
	if ($_POST['nouveau']) {
		$saveJoueurQuery = "insert into joueur(nom,prenom,id_lequipe,club_id,poste,id_ws) values('{$nom}','{$prenom}','{$id_lequipe}',{$clubId},'{$position}',{$id_ws})";
		$joueurId = mysql_insert_id();
	} else {
		$saveJoueurQuery = "update joueur set nom='{$nom}', prenom='{$prenom}', id_lequipe='{$id_lequipe}', club_id={$clubId}, poste='{$position}', id_ws={$id_ws} where id='{$_POST['id']}'";
		$joueurId = $_POST['id'];
	}
	$db->query($saveJoueurQuery) or die('Error, insert query failed, see log');
	
	$db->query("insert into info(date,ekyp_concernee_id,joueur_concerne_id,type,complement_float) values (now(),0,{$joueurId},'TR',NULL)");
	
	header('Location: ../index.php?page=manageJoueurs');
	exit();
	//echo $position;
?>