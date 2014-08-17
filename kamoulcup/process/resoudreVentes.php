<?php
include('checkAccess.php');
//checkAccess(4);
include("../includes/db.php");
include ('params/ekypParams.php');
include('api_score.php');
include('api_resolution.php');
include('debugTrace.php');
//Récupération de toutes les ventes expirées en attente de résolution
// Il faut d'abord s'occuper des RE
$listREQuery = $db->getArray("select id,auteur_id,joueur_id,montant,prix_reserve,type,departage_attente from vente where (type='RE') and (resolue=0)");
if ($listREQuery != NULL) {
	foreach ($listREQuery as $vente) {
		$trace = resoudVente($vente['id']);
		historiqueDebug($db,$vente['id'],$trace);
	}
}

// Enfin on résoud les ventes "normales"
$listVentesQuery = $db->getArray("select id,auteur_id,joueur_id,montant,prix_reserve,type,departage_attente from vente where (date_finencheres < now()) and (resolue=0) and type in ('PA','MV') order by date_soumission asc");
if ($listVentesQuery != NULL) {
	foreach ($listVentesQuery as $vente) {
		if (intval($vente['departage_attente'])>0) {
			$trace = resoudBallotage($vente['id']);
		} else {
			$trace = resoudVente($vente['id']);
		}
		historiqueDebug($db,$vente['id'],$trace);
	}
}
calculScoresToutesEkyps($db);
header('Location: ../index.php?page=mouvements');
exit();
?>