<?php
include('../../../process/checkAccess.php');
checkAccess(5);
include("../../../includes/db.php");
include('../../../process/validateForm.php');

$mercatoId = $_POST['mercatoId'];

// Requête de sélection des gagnants d'enchères
$encheresQ = "SELECT o2.off_joueur_id,o2.off_ekyp_id, o2.off_montant, count(o2.off_ekyp_id) as nbMaxEnchere FROM (
select off_joueur_id,max(off_montant) as off_montant from km_offre WHERE off_mercato_id={$mercatoId} group by off_joueur_id
) o1 join km_offre o2 on (o2.off_montant=o1.off_montant and o2.off_joueur_id=o1.off_joueur_id) group by o2.off_joueur_id";
// Requete pour connaitre la journee courante
$journeeQ = "select id from journee order by date desc limit 1";
$lastJournee = 0;
$currentJourneeArray = $db->getArray($journeeQ);
if (currentJourneeArray != NULL) {
	$lastJournee = $currentJourneeArray[0][0];
}

$encheresMax = $db->getArray($encheresQ);
$redistribution = array();
$franchisesQ = "select id from ekyp where km=1";
$franchises = $db->getArray($franchisesQ);
$nbEkyps=sizeof($franchises);
// init du tableau
foreach ($franchises as $value) {
	$redistribution[$value[0]]=0.0;
}

if ($encheresMax != NULL) {
	$joueursEgalite = array();
	foreach ($encheresMax as $value) {
		if($value['nbMaxEnchere'] == 1) {
			// On peut maintenant enregistrer l'engagement
			$redistribution = registerEngagement($value['off_ekyp_id'],$value['off_joueur_id'],$value['off_montant'],$lastJournee,$redistribution,$nbEkyps,$mercatoId);

		} else {
			// Les égalités sont conservées pour traitement ultérieur.
			array_push($joueursEgalite, $value['off_joueur_id']);
		}
	}
	// Traitement des égalités (tirage au sort)
	$nbEq = sizeof($joueursEgalite);
	for ($i = 0; $i < $nbEq; $i++) {
		// Recup des tops encheres sur ce joueur
		$joueurId = $joueursEgalite[$i];
		$vainqueursPotentielsQ="SELECT off_ekyp_id,off_montant FROM `km_offre` WHERE off_joueur_id={$joueurId} AND off_montant =
			(SELECT max( off_montant ) FROM km_offre WHERE off_joueur_id={$joueurId} ) ";
		$vainqueursPotentiels = $db->getArray($vainqueursPotentielsQ);
		$nbVP = sizeof($vainqueursPotentiels);
		// Tirage aléatoire
		$index = rand(0,$nbVP-1);
		$vainqueur = $vainqueursPotentiels[$index]['off_ekyp_id'];
		$redistribution = registerEngagement($vainqueur,$joueurId,$vainqueursPotentiels[$index]['off_montant'],$lastJournee,$redistribution,$nbEkyps,$mercatoId);
	}
}

// Mercato traité : on ferme
$db->query("update km_mercato set mer_processed=1 where mer_id={$mercatoId}");

// Redistribution
foreach($redistribution as $ekyp => $prime) {
	if ($prime > 0) {
		registerFinances($ekyp,(float) $prime,'Prime de redistribution');
	}
}

function registerEngagement($ekypId,$joueurId,$montant,$journee,$redistrib, $nbFranchises, $mercatoId){
	global $db;
	// marquage de l'offre gagnant
	$db->query("update km_offre set off_winner=1 where off_mercato_id={$mercatoId} and off_joueur_id={$joueurId} and off_ekyp_id={$ekypId}");
	// Existing engagement ?
	$existingQ = "select eng_id, eng_ekyp_id from km_engagement where eng_joueur_id={$joueurId} and eng_date_depart IS NULL";
	$existing = $db->getArray($existingQ);
	$joueurQ = "select prenom, nom from joueur where id={$joueurId} limit 1";
	$joueur = $db->getArray($joueurQ);
	$nomJoueur = $joueur[0]['prenom'].' '.$joueur[0]['nom'];
	$part=0.0;

	if ($existing != NULL) {
		// Le joueur était sous contrat : c'est le vendeur qui reçoit tout l'argent.
		$exEkypId = $existing[0]['eng_ekyp_id'];
		$exId=$existing[0]['eng_id'];
		$db->query("update km_engagement set eng_date_depart=now() where eng_id={$exId}");
		$event = "Vente du joueur {$nomJoueur}";
		registerFinances($exEkypId,$montant,$event);
	} else {
		// Redistribution de la somme dépensée
		$part = (float) ((float)$montant) / ((float) ($nbFranchises-1)) ;
		foreach($redistrib as $key => $value) {
			if ($key != $ekypId) {
				$redistrib[$key] = ((float) $value) + ((float) $part);
			}
		}
	}
	// Enregistrement de l'engagement avec l'acheteur
	$db->query("insert into km_engagement(eng_ekyp_id,eng_joueur_id,eng_salaire,eng_date_arrivee,eng_montant) values ({$ekypId},{$joueurId},(select scl_salaire from km_const_salaire_classe inner join km_join_joueur_salaire on scl_id=jjs_salaire_classe_id where jjs_journee_id={$journee} and jjs_joueur_id={$joueurId}), now(), {$montant})");
	// Finances
	$event = "Achat du joueur {$nomJoueur}";
	registerFinances($ekypId,-$montant,$event);
	return $redistrib;
}

function registerFinances($ekypId,$montant,$event) {
	global $db;
	// Récup du solde actuel de la franchise
	$soldeQ = "select fin_solde from km_finances where fin_ekyp_id={$ekypId} order by fin_date desc, fin_id desc limit 1";
	$solde = $db->getArray($soldeQ);
	$nouveauSolde = round(floatval($solde[0][0]) + ((float) $montant),1); // montant positif ou negatif
	$db->query("insert into km_finances(fin_ekyp_id,fin_date,fin_transaction,fin_solde,fin_event) values ({$ekypId},now(),{$montant},{$nouveauSolde},'{$event}')");
}

header('Location: ../index.php');
exit();
?>