<?php
include('checkAccess.php');
checkAccess(1);
checkEkyp();
include("../includes/db.php");
include('validateForm.php');
include('reventeJoueur.php');
include('computeDate.php');

$joueurId = correctSlash($_POST['joueurId']);

$montant = correctSlash($_POST['montant']);
valideFloat($montant,'Montant','detailJoueur&joueurid='.$joueurId);

$reserve = correctSlash($_POST['reserve']);
valideFloat($reserve,'Prix de r�serve','detailJoueur&joueurid='.$joueurId);


// Vérification que le joueur nous appartient
$checkTransfertQuery = $db->getArray("select prix_achat from transfert where joueur_id='{$joueurId}' and ekyp_id='{$_SESSION['myEkypId']}' limit 1");
if ($checkTransfertQuery == NULL) {
	$err = "Ce joueur ne vous appartient pas";
	echo "<script>window.location.replace('../index.php?page=detailJoueur&joueurid={$joueurId}&ErrMsg={$err}');</script>";
	exit();
}
//Verification qu'une vente n'est pas d�j� en cours pour ce joueur
if ( isVenteEnCours($db,$_SESSION['pouleId'],$joueurId)) {
	$err = "Ce joueur est déjà en vente actuellement";
	echo "<script>window.location.replace('../index.php?page=detailJoueur&joueurid={$joueurId}&ErrMsg={$err}');</script>";
	exit();
}


if ($_POST['typeVente'] == 'RE') {
	if (! isReventeBaPossible($db,$joueurId,$_SESSION['myEkypId']) ) {
		$err = "Vous ne pouvez plus faire de revente à la Banque Arbitre";
		echo "<script>window.location.replace('../index.php?page=detailJoueur&joueurid={$joueurId}&ErrMsg={$err}');</script>";
		exit();
	}
	// On ne fait pas confiance au montant passé dans la requête dans ce cas: on le recalcule
	$calculMontant = 0;
	$achat = floatval($checkTransfertQuery[0]['prix_achat']);
	$jokerGrille = true;
	if (isReventeForceMajeure($db,$joueurId)) {
		$jokerGrille = false;
		$calculMontant = round(floatval($EKY_rachatForceMajeure*$achat),1);
	} else {
		$calculMontant = round(floatval($EKY_rachatBA*$achat),1);
	}

	// insert vente
	// Nouveauté : la revente d'un joueur n'est pas immédiate : on met résolution à 0 et on fera la résol lors de la prochaine session.
	$db->query("insert into vente(date_soumission,date_finencheres,type,joueur_id,auteur_id,montant,resolue,poule_id,prix_reserve,departage_attente) values (now(),now(),'RE','{$joueurId}','{$_SESSION['myEkypId']}',{$calculMontant},0,'{$_SESSION['pouleId']}',0,0) ");
	//TODO : déplacer les lignes qui suivent dans api_resolution.
	//$venteId = mysql_insert_id();
	//$db->query("insert into resolution (vente_id,montant_gagnant,gagnant_id,reserve,annulee) values ('{$venteId}',{$calculMontant},{$_SESSION['myEkypId']},0,0) ");
	////Libération du joueur
	//$db->query("delete from transfert where joueur_id='{$joueurId}' and ekyp_id='{$_SESSION['myEkypId']}' and poule_id='{$_SESSION['pouleId']}' limit 1");
	//Ajout de l'argent récupéré au budget
	$getBudgetQuery = $db->getArray("select budget,revente_ba from ekyp where id={$_SESSION['myEkypId']} limit 1");
	//$solde = floatval($getBudgetQuery[0]['budget'])+$calculMontant;
	$nbReventes = intval($getBudgetQuery[0]['revente_ba']);
	if ($jokerGrille) {
		$nbReventes++;
	}
	//$db->query("update ekyp set budget={$solde},revente_ba={$nbReventes} where id='{$_SESSION['myEkypId']}' limit 1");
	$db->query("update ekyp set revente_ba={$nbReventes} where id={$_SESSION['myEkypId']} limit 1");


	$db->query("insert into info(date,ekyp_concernee_id,joueur_concerne_id,type,complement_float) values (now(),{$_SESSION['myEkypId']},{$joueurId},'VE',$calculMontant)");

	echo "<script>window.location.replace('../index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}');</script>";
	exit();
}

if ($_POST['typeVente'] == 'MV') {

	$mvP = true;
	$mvP = isMVPossible($db,$_SESSION['myEkypId']);

	if ( $mvP ) {
		// insert vente
		$montantVente = round(floatval($montant),1);
		$montantReserve = round(floatval($reserve),1);
		$userPouleId = intval($_SESSION['pouleId']);
		$delaiPeriode = $db->getArray("select delai_encheres from periode where date_debut < now() and date_fin > now() and poule_id={$userPouleId} limit 1");
		$delai = intval($delaiPeriode[0][0]);
		$dateFin = date("Y-m-d H:i:s",calculDateFinEnchere(time(),$delai));
		$db->query("insert into vente (date_soumission,date_finencheres,type,joueur_id,auteur_id,montant,resolue,poule_id,prix_reserve,departage_attente) values (now(),'$dateFin','MV','{$joueurId}','{$_SESSION['myEkypId']}',{$montantVente},0,'{$_SESSION['pouleId']}',{$montantReserve},0) ");
		echo "<script>window.location.replace('../index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}');</script>";
		exit();

	} else {

		$err = "Vous avez deja atteint votre quota de joueurs en vente en cours";
		echo "<script>window.location.replace('../index.php?page=detailJoueur&joueurid={$joueurId}&ErrMsg={$err}');</script>";
		exit();
	}
}

$err = "Type de vente incorrect.";
echo "<script>window.location.replace('../index.php?page=detailJoueur&joueurid={$joueurId}&ErrMsg={$err}');</script>";
exit();
?>