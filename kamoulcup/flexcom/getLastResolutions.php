<?php
include('JSON.php');
include('../includes/db.php');

class Vente {
	var $id;
	var $typeVente;
	var $auteur;
	var $dateMiseEnVente;
	var $nomJoueur;
	var $prenombJoueur;
	var $joueurDbId;
	var $posteJoueur;
	var $resultat;
	var $clubJoueur;
}

class Resultat {
	var $montantPA;
	var $meilleureOffre;
	var $vainqueur;
	var $montantDeuxiemeOffre;
	var $isBallotage;
	var $isAnnulee;
	var $isReserve;
	var $dateBallotage;
	var $dateExpiration;
}
//
//function unhtmlentities($chaineHtml) {
//    $tmp = get_html_translation_table(HTML_ENTITIES);
//    $tmp = array_flip ($tmp);
//    $chaineTmp = strtr ($chaineHtml, $tmp);
//    return $chaineTmp;
//    //return $chaineHtml;
//}


$pouleId = intval($_GET['pouleid']);
$out = Array();
$listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as idVente, ve.type, ve.montant, ek.nom as nomEkyp, ek.id as idEkyp, jo.club_id, jo.id as idJoueur, jo.id_lequipe as eqJoueur, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin, date_format(ve.date_soumission,'%d/%m %H:%i:%s') as dateSoumission,ve.departage_attente from joueur as jo, vente as ve, ekyp as ek where ((ve.resolue=1) or (ve.resolue=0 and ve.departage_attente>0)) and ve.poule_id={$pouleId} and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_finencheres desc limit 20"); 
if ($listVentesQuery != NULL) {
	foreach($listVentesQuery as $vente) {
		$club = 'Sans club';
		if ($vente['club_id'] != NULL) {
			$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id={$vente['club_id']} limit 1");
			$club = $getClubQuery[0]['nom'];
		}
		
		$jsonVente = new Vente();
		$jsonResultat = new Resultat();
		$jsonVente->id = $vente['idVente'];
		$jsonVente->typeVente = $vente['type'];
		$jsonVente->auteur = (htmlspecialchars_decode($vente['nomEkyp']));
		$jsonVente->dateMiseEnVente = (htmlspecialchars_decode($vente['dateSoumission']));
		$jsonVente->nomJoueur = (htmlspecialchars_decode($vente['nomJoueur']));
		$jsonVente->prenomJoueur = (htmlspecialchars_decode($vente['prenom']));
		$jsonVente->joueurDbId = $vente['eqJoueur'];
		$jsonVente->posteJoueur = $vente['poste'];
		$jsonVente->clubJoueur = $club;
		
		$jsonResultat->dateExpiration = (htmlspecialchars_decode($vente['dateFin']));
		$jsonResultat->montantPA = round(floatval($vente['montant']),1);
		if (intval($vente['departage_attente']) > 0) {
			$jsonResultat->isBallotage=true;
			$ballotageQuery = $db->getArray("select date_format(de.date_expiration,'%d/%m %H:%i:%s') from departage_vente as de where vente_id={$vente['idVente']} limit 1");
			if ($ballotageQuery != NULL) {
				$jsonResultat->dateBallotage = (htmlspecialchars_decode($ballotageQuery[0][0]));
			}
		} else {
			$resolution = $db->getArray("select res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, ek.nom,ek.id as ekId from resolution as res, ekyp as ek where res.vente_id={$vente['idVente']} and res.gagnant_id=ek.id limit 1");
			if ($resolution != NULL) {
				if (intval($resolution[0]['annulee']) == 1) {
					$jsonResultat->isAnnulee = 1;
				} else if (intval($resolution[0]['reserve']) == 1) {
					$jsonResultat->isReserve = 1;
				} else {
					$jsonResultat->meilleureOffre = round(floatval($resolution[0]['montant_gagnant']),1);
					$jsonResultat->vainqueur = (htmlspecialchars_decode($resolution[0]['nom']));
					$jsonResultat->montantDeuxiemeOffre = $resolution[0]['montant_deuxieme'];
				}
			}
		}
		$jsonVente->resultat = $jsonResultat;
		array_push ($out,$jsonVente);
	}
}

$sJSON = new Services_JSON();
echo $sJSON->encode($out);

?>