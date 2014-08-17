<?php
include('computeDate.php');
include('api_feed.php');
//
// Fonctions utisées par les procédures de résolution d'ench�res
//


// Fonction qui vérifie si un transfert est réalisable (assez d'argent, pas trop de joueurs)
function isTransfertPossible($ekypId,$montant) {
	global $db;
	global $EKY_nbmaxjoueurs;
	$getBudgetQuery = $db->getArray("select budget from ekyp where id='{$ekypId}' limit 1");
	if (round(floatval($getBudgetQuery[0][0]),1) < $montant) {
		// Trop cher
		return 0;
	}
	$getNbJoueursQuery = $db->getArray("select count(joueur_id) from transfert where ekyp_id='{$ekypId}' limit 1");
	if ($getNbJoueursQuery == NULL) {
		// Pas de joueurs transf�r� : ok
		return 1;
	}
	if (intval($getNbJoueursQuery[0][0]) >= $EKY_nbmaxjoueurs) {
		// Plus de place dans l'effectif
		return 0;
	} else {
		return 1;
	}
}

// Fonction qui vérifie si l'enchère postée par l'ékyp considérée lui permet toujours d'honorer ses autres PAs.
function isPaHonorable($ekypId, $montant, $joueurId) {
	global $db;
	global $EKY_nbmaxjoueurs;
	$getPaQuery = $db->getArray("select sum(ve.montant), count(*) from vente as ve where ve.resolue=0 and ve.type='PA' and ve.auteur_id='{$ekypId}' and ve.joueur_id!='{$joueurId}'");
	if ($getPaQuery == NULL) {
		// Pas de PA en cours : forcement ok
		return 1;
	} else {
		// S'il ne reste que de la place pour accueillir les joueurs en PA, les ench�res en cours sur les autres
		// ne peuvent pas �tre accept�es
		$getNbJoueursQuery = $db->getArray("select count(joueur_id) from transfert where ekyp_id={$ekypId} limit 1");
		if ($getNbJoueursQuery != NULL
		&& (intval($getNbJoueursQuery[0][0]) >= ($EKY_nbmaxjoueurs - intval($getPaQuery[0][1])))) {
			// Il n'y plus de place !
			return 0;
		}
			
		$getBudgetQuery = $db->getArray("select budget from ekyp where id='{$ekypId}' limit 1");
		$futurBudget = round(floatval($getBudgetQuery[0][0]) - floatval($getPaQuery[0][0]),1);
		if ($montant > $futurBudget) {
			return 0;
		} else {
			return 1;
		}
	}
}

// Fonction qui indique qu'une enchere est non prise en compte pour une raison quelconque
function exclureEnchere($enchId) {
	global $db;
	$db->query("update enchere set exclue=1 where id={$enchId} limit 1");
}

function doTransfert($venteId,$joueurId,$ekypId,$montant,$deuxieme,$fromEkyp) {
	global $db;
	global $EKY_pourcentageRevente;
	$getPouleQuery = $db->getArray("select poule_id,budget from ekyp where id={$ekypId} limit 1");
	$pouleId = $getPouleQuery[0][0];
	$budgetAcheteur = $getPouleQuery[0][1];

	// maj table transfert
	//Suppr des anciens transfert pour ce joueur, s'il y en a
	$db->query("delete from transfert where joueur_id={$joueurId} and poule_id={$pouleId}");

	// Récupération de l'éventuel coefficient de bonus d'achat.
	$getCoeffQuery = $db->getArray("select coeff_bonus_achat from vente where id={$venteId} limit 1");

	//Création de ce nouveau transfert
	$coeff = 1.0+round(floatval($getCoeffQuery[0][0]),3);
	$db->query("insert into transfert(joueur_id,prix_achat,ekyp_id,anciennete,transfert_date,poule_id,coeff_bonus_achat) values ('{$joueurId}',{$montant},'{$ekypId}',0,now(),'{$pouleId}',{$coeff})");

	// maj table resolution
	// Suppr des anciennes résolutions, s'il y en a (ne devrait pas)
	$db->query("delete from resolution where vente_id='{$venteId}'");
	//Création nouvelle résolution
	$db->query("insert into resolution(vente_id,montant_gagnant,montant_deuxieme,gagnant_id) values ('{$venteId}',{$montant},{$deuxieme},'{$ekypId}')");
	$resolId = mysql_insert_id();
	// maj table ekyp (montant  budget)
	$budgetRestant = $budgetAcheteur - $montant;

	// sauvegarde info
	$db->query("insert into info(date,ekyp_concernee_id,joueur_concerne_id,type,complement_float) values (now(),{$ekypId},{$joueurId},'AC',$montant)");

	$db->query("update ekyp set budget={$budgetRestant} where id='{$ekypId}' limit 1");
	if ($fromEkyp > 0) {
		// joueur acheté à une autre ekyp : son budget augmente de 90% de la somme
		$getBudgetVendeurQuery = $db->getArray("select budget from ekyp where id={$fromEkyp} limit 1");
		$montant = $montant*$EKY_pourcentageRevente;
		$nouveauBudget = round((floatval($getBudgetVendeurQuery[0][0]) + $montant),1);
		$db->query("update ekyp set budget={$nouveauBudget} where id='{$fromEkyp}' limit 1");
		$db->query("insert into info(date,ekyp_concernee_id,joueur_concerne_id,type,complement_float) values (now(),{$fromEkyp},{$joueurId},'VE',$montant)");
	}

	// suppr des departages
	// INUTILE.
	//$db->query("delete from departage_vente where vente_id='{$venteId}'");
	// maj table vente
	$db->query("update vente set resolue=1,departage_attente=0 where id='{$venteId}' limit 1");

	// Génération du feed
	createResolutionEntry($resolId);
}

function departageVente($venteId,$listAuteurIds,$montant) {
	global $db;
	// On rerajoute une durée d'enchère comme temps max de departage
	//$dureeEnchereQuery = $db->getArray("select delai_encheres from periode where date_debut < now() order by date_fin desc limit 1");
	$dureeEnchere = 34;
	//if ($dureeEnchereQuery != NULL) {
	//	$dureeEnchere = $dureeEnchereQuery[0][0];
	//}
	// on retranche deux heures de délai pour finir un
	$debTime = time();
	$finTime = calculDateFinEnchere($debTime,$dureeEnchere);
	$insFin = date("Y-m-d H:i:s",$finTime);
	// Insert des departage_vente
	foreach ($listAuteurIds as $auteurId) {
		$db->query("insert into departage_vente(vente_id,montant_initial,ekyp_id,date_expiration) values ({$venteId},{$montant},{$auteurId},str_to_date('{$insFin}','%Y-%m-%d %H:%i:%s')) ");
	}
	// Maj de la vente avec le nombre de nouvelles offres en attente.
	$nbOffres = count($listAuteurIds);
	$db->query("update vente set resolue=0,departage_attente={$nbOffres} where id={$venteId}");
}

function doRandomTransfert($venteId,$joueurId,$ekypIds,$montant,$deuxieme,$fromEkyp) {
	global $db;
	$nbEkyps = count($ekypIds);
	if ($nbEkyps == 0) {
		cancelVente($venteId);
		return '0';
	} else {
		// Gagnant tiré au sort
		srand();
		$indexGagnant = rand(0,($nbEkyps-1));
		$gagnantId = $ekypIds[$indexGagnant];
		doTransfert($venteId,$joueurId,$gagnantId,$montant,$deuxieme,$fromEkyp);
		return $gagnantId;
	}
}

function cancelVente($venteId) {
	global $db;
	// Gagnant = auteur de la vente
	$getAuteurQuery = $db->getArray("select auteur_id from vente where id='{$venteId}' limit 1");
	$gagnantId = $getAuteurQuery[0][0];
	// maj table resolution
	// Suppr des anciennes r�solutions, s'il y en a (ne devrait pas)
	$db->query("delete from resolution where vente_id='{$venteId}'");
	//Cr�ation nouvelle r�solution
	$db->query("insert into resolution(vente_id,gagnant_id,annulee) values ('{$venteId}','{$gagnantId}',1)");
	// maj table vente
	$db->query("update vente set resolue=1,departage_attente=0 where id='{$venteId}' limit 1");
	// suppr des departage s'il y en a
	//$db->query("delete from departage_vente where vente_id='{$venteId}'");
}

function reserveVente($venteId) {
	global $db;
	// Gagnant = auteur de la vente
	$getAuteurQuery = $db->getArray("select auteur_id from vente where id='{$venteId}' limit 1");
	$gagnantId = $getAuteurQuery[0][0];
	// maj table resolution
	// Suppr des anciennes r�solutions, s'il y en a (ne devrait pas)
	$db->query("delete from resolution where vente_id='{$venteId}'");
	//Cr�ation nouvelle r�solution
	$db->query("insert into resolution(vente_id,gagnant_id,reserve) values ('{$venteId}','{$gagnantId}',1)");
	// maj table vente
	$db->query("update vente set resolue=1,departage_attente=0 where id='{$venteId}' limit 1");
	// suppr des departage s'il y en a
	//$db->query("delete from departage_vente where vente_id='{$venteId}'");
}

// Fonction qui gère le cas "Pas d'enchères reçues sur une vente "
function handleNoEnchere($venteId, $auteurVenteId, $typeVente, $montantVente, $joueurId) {
	$trace = 'Aucune enchère valide reçue pour la vente '.$venteId.'<br/>';
	if ($typeVente == 'PA') {
		if (isTransfertPossible($auteurVenteId,$montantVente)) {
			$trace .= 'Auteur de la PA remporte vente [id, montant]=['.$auteurVenteId.','.$montantVente.']<br/>Enregistrement...';
			doTransfert($venteId, $joueurId,$auteurVenteId,$montantVente,0,0);
			if (mysql_errno()) {
				$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
			} else {
				$trace .= 'Enregistrement effectué<br/>';
			}
		} else {
			$trace .= 'ECHEC: Auteur ne peut pas honorer PA [id,montant]=['.$auteurVenteId.','.$montantVente.']<br/>';
		}
	} else {
		$trace .= 'Aucun acheteur pour cette MV. Annulation vente...<br/>';
		cancelVente($venteId);
		if (mysql_errno()) {
			$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
		} else {
			$trace .= 'Annulation effectué<br/>';
		}
	}
	return $trace;
}

// Fonction qui gère la sélection de l'ench�re sup�rieure et retourne un tableau contenant
// idx 0: tableau des ids d'offres maximum
// idx 1: montant de la meilleure offre
// idx 2: valeur de la 2e meilleure offre
// idx 3: trace
function handleEncheres($venteId,$montantVente,$montantReserve, $listEncheres) {
	global $db;
	$getVenteQuery = $db->getArray("select joueur_id from vente where id='{$venteId}' limit 1");
	$resTab = Array();
	$debugBuffer = '';
	$montantOffreMax = 0;
	$idOffresMax = Array();
	$deuxiemeOffre = 0;
	$i = 0;
	$finResol = false;
	$nbEncheres = count($listEncheres);
	while ((!$finResol) && ($i < $nbEncheres)) {
		$currEnch = $listEncheres[$i];
		$transfertPossible = isTransfertPossible($currEnch['auteur'],$currEnch['montant']);
		$paHonorable = isPaHonorable($currEnch['auteur'],$currEnch['montant'],$getVenteQuery[0]['joueur_id']);
		if ( $paHonorable && $transfertPossible) {
			$debugBuffer .= 'Enchere '.$currEnch['id'].' prise en compte.<br/>';
			if ($currEnch['montant'] >= $montantOffreMax) {
				// Offre la plus �lev�e
				$montantOffreMax = $currEnch['montant'];
				array_push($idOffresMax,$currEnch['auteur']);
			} else {
				$deuxiemeOffre = $currEnch['montant'];
			}
		} else {
			exclureEnchere($currEnch['id']);
			if (! $transfertPossible) {
				$debugBuffer .= 'Enchere '.$currEnch['id'].' rejet�e: Trop de joueurs sous contrat ou manque argent. Transfert impossible.<br/>';
			}
			if (! $paHonorable) {
				$debugBuffer .= 'Enchere '.$currEnch['id'].' rejet�e: Conflit avec PA en cours. Transfert impossible.<br/>';
			}
		}
		$i++;
		$finResol = (($deuxiemeOffre > 0) && ($montantOffreMax > 0));
	}
	array_push($resTab,$idOffresMax);
	array_push($resTab,$montantOffreMax);
	//echo "#### {$montantOffreMax} Ka";
	array_push($resTab,$deuxiemeOffre);
	array_push($resTab,$debugBuffer);
	return $resTab;
}


// Fonction qui gère la sélection de l'enchère supérieure et retourne un tableau contenant
// idx 0: tableau des ids d'offres maximum
// idx 1: montant de la meilleure offre
// idx 2: valeur de la 2e meilleure offre
// idx 3: trace
function handleSurench($venteId,$listSurench) {
	global $db;
	$getVenteQuery = $db->getArray("select joueur_id from vente where id='{$venteId}' limit 1");
	$resTab = Array();
	$debugBuffer = '';
	$montantOffreMax = 0;
	$idOffresMax = Array();
	$deuxiemeOffre = 0;
	$i = 0;
	$finResol = false;
	$nbEncheres = count($listSurench);
	while ((!$finResol) && ($i < $nbEncheres)) {
		$currEnch = $listSurench[$i];
		$transfertPossible = isTransfertPossible($currEnch['ekyp_id'],$currEnch['montant']);
		$paHonorable = isPaHonorable($currEnch['ekyp_id'],$currEnch['montant'],$getVenteQuery[0]['joueur_id']);
		if ( $paHonorable && $transfertPossible) {
			$debugBuffer .= 'Surench '.$currEnch['id'].' prise en compte.<br/>';
			if ($currEnch['montant'] >= $montantOffreMax) {
				// Offre la plus �lev�e
				$montantOffreMax = $currEnch['montant'];
				array_push($idOffresMax,$currEnch['ekyp_id']);
			} else {
				$deuxiemeOffre = $currEnch['montant'];
			}
		} else {
			if (! $transfertPossible) {
				$debugBuffer .= 'Surenchere '.$currEnch['id'].' rejet�e: Trop de joueurs sous contrat ou manque argent. Transfert impossible.<br/>';
			}
			if (! $paHonorable) {
				$debugBuffer .= 'Surenchere '.$currEnch['id'].' rejet�e: Conflit avec PA en cours. Transfert impossible.<br/>';
			}
		}
		$i++;
		$finResol = (($deuxiemeOffre > 0) && ($montantOffreMax > 0));
	}
	array_push($resTab,$idOffresMax);
	array_push($resTab,$montantOffreMax);
	//echo "#### {$montantOffreMax} Ka";
	array_push($resTab,$deuxiemeOffre);
	array_push($resTab,$debugBuffer);
	return $resTab;
}


function resoudBallotage($venteId) {
	global $db;
	$trace = '';
	$getVenteQuery = $db->getArray("select auteur_id,joueur_id,montant,prix_reserve,type,departage_attente,resolue,unix_timestamp(date_soumission) as debTS, unix_timestamp(date_finencheres) as finTS from vente where id={$venteId} limit 1");
	if ($getVenteQuery == NULL) {
		$trace .= 'ECHEC: venteId inconnu ('.$venteId.')';
		return $trace;
	}
	if (intval($getVenteQuery[0]['resolue']) > 0) {
		$trace .= 'ECHEC: Vente déjà résolue';
		return $trace;
	}
	if (intval($getVenteQuery[0]['departage_attente']) == 0) {
		$trace .= 'ECHEC: Ce n\'est pas un ballotage';
		return $trace;
	}
	$nbAttendu = intval($getVenteQuery[0]['departage_attente']);
	$trace .= 'Résolution du ballotage venteId='.$venteId.'. '.$nbAttendu.' surenchères attendues.';
	$nbSurenchQuery = $db->getArray("select count(ekyp_id) from departage_vente where vente_id='{$venteId}' and montant_nouveau is not null");
	$expirQuery = $db->getArray("select (date_expiration < now()),unix_timestamp(date_expiration) from departage_vente where vente_id='{$venteId}' limit 1");
	$nbRecu = intval($nbSurenchQuery[0][0]);
	if (($nbRecu < $nbAttendu) && (! $expirQuery[0][0])) {
		$trace .= 'Toujours en attente de surencheres, resolution reportée<br/>';
		return $trace;
	}
	// A partir d'ici on peut résoudre le ballotage sans vergogne, tant pis pour les retardataires
	// Récolte de toutes les enchères jusqu'à la date de fin du ballotage

	$listSurenchQuery = $db->getArray("select dv.id,dv.ekyp_id, COALESCE(dv.montant_nouveau,dv.montant_initial) as montant from departage_vente as dv where dv.vente_id={$venteId} order by montant desc");
	// listEncheresQuery ne peut pas être NULL sinon ce ne serait pas un ballotage.
	if ($listSurenchQuery == NULL) {
		$trace .= 'ECHEC: aucune enchere relevée pour ce ballotage <br/>';
		return $trace;
	}
	$nbEnch = count($listSurenchQuery);
	$trace.= $nbEnch.' surench�re(s) valide(s) re�ue(s).<br/>';
	$enchResTab = handleSurench($venteId,$listSurenchQuery);
	$idOffresMax = $enchResTab[0];
	$montantOffreMax = $enchResTab[1];
	$deuxiemeOffre = $enchResTab[2];
	$trace.= $enchResTab[3];
	$trace .= 'Surenchères traitées. [id offres max='.implode(",",$idOffresMax).'][montant max='.$montantOffreMax.'][montant 2e='.$deuxiemeOffre.']';
	// Pas d'histoire de prix de réserve pour un ballotage
	switch (count($idOffresMax)) {
		case 0:
			$trace .= 'ECHEC: aucune enchere relev�e pour ce ballotage <br/>';
			return $trace;
			break;
		case 1:
			// Une seule meilleure offre (cas classique)
			$trace .= 'Meilleure enchère relevée [auteur,montant]=['.$idOffresMax[0].','.$montantOffreMax.']<br/>Enregistrement du transfert...<br/>';
			$fromEkyp = 0;
			if ($getVenteQuery[0]['type']=='MV') {
				$getPouleQuery = $db->getArray("select poule_id from ekyp where id='{$idOffresMax[0]}' limit 1");
				$pouleId = $getPouleQuery[0][0];
				$fromQuery = $db->getArray("select ekyp_id from transfert where joueur_id='{$getVenteQuery[0]['joueur_id']}' and poule_id='{$pouleId}'");
				$fromEkyp = $fromQuery[0][0];
			}
			doTransfert($venteId, $getVenteQuery[0]['joueur_id'],$idOffresMax[0],$montantOffreMax,$deuxiemeOffre,$fromEkyp);
			if (mysql_errno()) {
				$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
			} else {
				$trace .= 'Enregistrement effecut�<br/>';
			}
			break;
		default:
			// Plusieurs meilleures offres à départager.
			$trace .= 'Plusieurs meilleures offres � �galit�, vainqueur tir� au sort<br/>Random transfert...<br/>';
			doRandomTransfert($venteId,$getVenteQuery[0]['joueur_id'],$idOffresMax,$montantOffreMax,$montantOffreMax,$fromEkyp);
			if (mysql_errno()) {
				$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
			} else {
				$trace .= 'Enregistrement effectué<br/>';
			}
	}
	return $trace;
}

// Fonction qui résoud une vente de A à Z et retourne une trace de la resolution.
function resoudVente($venteId) {
	global $db;
	$trace = '';
	$getVenteQuery = $db->getArray("select auteur_id,joueur_id,montant,prix_reserve,type,departage_attente,resolue,unix_timestamp(date_soumission) as debTS, unix_timestamp(date_finencheres) as finTS from vente where id='{$venteId}' limit 1");
	if ($getVenteQuery == NULL) {
		$trace .= 'ECHEC: venteId inconnu ('.$venteId.')';
		return $trace;
	}
	if (intval($getVenteQuery[0]['resolue']) > 0) {
		$trace .= 'ECHEC: Vente déjà résolue';
		return $trace;
	}
	if (intval($getVenteQuery[0]['departage_attente']) > 0) {
		$trace .= 'ECHEC: Ballotage';
		return $trace;
	}
	// A partir d'ici : Vente valide. Etude des enchéres envoyées
	$trace='Résolution de la vente '.$venteId.'<br/>';

	if ($getVenteQuery[0]['type'] == 'RE') {
		$trace.='Revente du joueur à la banque<br/>';
		revendreJoueur($venteId,$getVenteQuery[0]['auteur_id'],$getVenteQuery[0]['joueur_id'],floatval($getVenteQuery[0]['montant']));
		return $trace;
	}

	$listEncheresQuery = $db->getArray("select en.id,en.montant,en.auteur from enchere as en,vente as ve,ekyp as ek where en.vente_id=ve.id and ve.id={$venteId} and auteur=ek.id and ek.poule_id=ve.poule_id and (en.montant >= {$getVenteQuery[0]['montant']}) and (unix_timestamp(date_envoi) > {$getVenteQuery[0]['debTS']}) and (unix_timestamp(date_envoi) < {$getVenteQuery[0]['finTS']}) order by en.montant desc");

	if ($listEncheresQuery == NULL) {
		$trace .= handleNoEnchere($venteId, $getVenteQuery[0]['auteur_id'], $getVenteQuery[0]['type'],$getVenteQuery[0]['montant'],$getVenteQuery[0]['joueur_id']);
	} else {
		// Il y a des enchères
		$nbEnch = count($listEncheresQuery);
		$trace.= $nbEnch.' enchère(s) valide(s) reçue(s).<br/>';
		$enchResTab = handleEncheres($venteId,$getVenteQuery[0]['montant'],$getVenteQuery[0]['prix_reserve'],$listEncheresQuery);
		$idOffresMax = $enchResTab[0];
		$montantOffreMax = $enchResTab[1];
		$deuxiemeOffre = $enchResTab[2];
		$trace.= $enchResTab[3];
		$trace .= 'Enchères traitées. [id offres max='.implode(",",$idOffresMax).'][montant max='.$montantOffreMax.'][montant 2e='.$deuxiemeOffre.']';
			
		if ($montantOffreMax < $getVenteQuery[0]['prix_reserve']) {
			$trace .= 'Prix de réserve '.$getVenteQuery[0]['prix_reserve'].'Ka non atteint. Annulation en cours...<br/>';
			reserveVente($venteId);
			if (mysql_errno()) {
				$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
			} else {
				$trace .= 'Annulation effecut�e<br/>';
			}
		} else {
			switch (count($idOffresMax)) {
				case 0:
					// Pas d'enchère valide -> vers l'auteur de la PA
					$trace .= handleNoEnchere($venteId, $getVenteQuery[0]['auteur_id'], $getVenteQuery[0]['type'],$getVenteQuery[0]['montant'],$getVenteQuery[0]['joueur_id']);
					break;
				case 1:
					// Une seule meilleure offre (cas classique)
					$trace .= 'Meilleure enchère relevée [auteur,montant]=['.$idOffresMax[0].','.$montantOffreMax.']<br/>Enregistrement du transfert...<br/>';
					$fromEkyp = 0;
					if ($getVenteQuery[0]['type']=='MV') {
						$getPouleQuery = $db->getArray("select poule_id from ekyp where id='{$idOffresMax[0]}' limit 1");
						$pouleId = $getPouleQuery[0][0];
						$fromQuery = $db->getArray("select ekyp_id from transfert where joueur_id='{$getVenteQuery[0]['joueur_id']}' and poule_id='{$pouleId}'");
						$fromEkyp = $fromQuery[0][0];
					}
					doTransfert($venteId, $getVenteQuery[0]['joueur_id'],$idOffresMax[0],$montantOffreMax,$deuxiemeOffre,$fromEkyp);
					if (mysql_errno()) {
						$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
					} else {
						$trace .= 'Enregistrement effecut�<br/>';
					}
					break;
				default:
					// Plusieurs meilleures offres à départager.
					$trace .= 'Plusieurs meilleures offres à départager<br/>Le gagnant va être tiré au sort...';
					// On arrête avec les ballotages : tirage au sort immédiat
					// departageVente($venteId,$idOffresMax,$montantOffreMax);
					doRandomTransfert($venteId,$getVenteQuery[0]['joueur_id'],$idOffresMax,$montantOffreMax,$montantOffreMax,$fromEkyp);
					if (mysql_errno()) {
						$trace .= 'ECHEC Erreur mysql: '.mysql_error().'<br/>';
					} else {
						$trace .= 'Enregistrement effectué<br/>';
					}
			}
		}
	}
	return $trace;
}

// Revente à la banque.
function revendreJoueur($venteId,$ekypId,$joueurId,$montant) {
	global $db;
	$db->query("insert into resolution (vente_id,montant_gagnant,gagnant_id,reserve,annulee) values ({$venteId},{$montant},{$ekypId},0,0) ");
	$db->query("update vente set resolue=1 where id={$venteId}");
	// Libération du joueur
	$db->query("delete from transfert where joueur_id={$joueurId} and ekyp_id={$ekypId} limit 1");
	//Ajout de l'argent récupéré au budget
	$getBudgetQuery = $db->getArray("select budget from ekyp where id={$ekypId} limit 1");
	$solde = floatval($getBudgetQuery[0]['budget'])+$montant;
	$db->query("update ekyp set budget={$solde} where id={$ekypId} limit 1");
}

?>