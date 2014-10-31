<?php
	include('../../../process/checkAccess.php');
	checkAccess(5);
	include("../../../includes/db.php");
	include('../../../process/validateForm.php');
    include('../../model/KMConstants.php');

	$journeeId = correctSlash($_POST['journee']);
	
	// 	1) Récupérer la date de la journée choisie
	$selectDateQ = $db->getArray("select date from journee where id={$journeeId}");
	$jDate = $selectDateQ[0][0];

    if (strtotime($jDate)>time() ) {
        // Trop tôt
        echo "La journée n'a pas encore eu lieu.";
        die();
    }


// Algo:
// 1- On essaye de prendre la compo rentrée par les joueurs. On y exclue les joueurs qui ne sont plus sous contrat
// 2- Si pas de compo, on prend celle de la journée d'avant. Même exclusion <---- NON ON FAIT PAS CE 2/
// 3- On remplace tous les trous par les joueurs sous contrat hors compo par ordre décroissant de salaire.

    $cleanCompoQ = "delete from km_selection_ekyp_journee where sej_journee_id={$journeeId} and sej_engagement_id in (select eng_id from km_engagement inner join journee on id={$journeeId} where (date<=eng_date_arrivee) or (date>eng_date_depart))";
// Cela vide les sej invalides pour toutes les franchises à la fois :
    $db->query($cleanCompoQ);

// TODO : vraie gestion des ligues pour sélectionner les franchises
$franchisesQ = "select id from ekyp where km=1";
$franchises = $db->getArray($franchisesQ);

$possibleCompoQ = "select journee.id,joueur.poste,eng_id,sej_substitute from km_engagement inner join joueur on eng_joueur_id=joueur.id inner join journee on journee.id={$journeeId} left outer join km_selection_ekyp_journee on sej_journee_id=journee.id and sej_engagement_id=eng_id where (date>=eng_date_arrivee) and (date<eng_date_depart or eng_date_depart IS NULL) and eng_ekyp_id={$fr['id']} order by field(poste,'G','D','M','A'),sej_substitute,eng_salaire desc, eng_date_arrivee desc";
foreach ($franchises as $fr) {
    $possibleCompoQ = "select journee.id,joueur.poste,eng_id,sej_substitute from km_engagement inner join joueur on eng_joueur_id=joueur.id inner join journee on journee.id={$journeeId} left outer join km_selection_ekyp_journee on sej_journee_id=journee.id and sej_engagement_id=eng_id where (date>=eng_date_arrivee) and (date<eng_date_depart or eng_date_depart IS NULL) and eng_ekyp_id={$fr['id']} order by field(poste,'G','D','M','A'),sej_substitute,eng_salaire desc, eng_date_arrivee desc";
    $selection=$db->getArray($possibleCompoQ);
    adjustSelection($selection,$db);
}

	
	header('Location: ../index.php');
	die();

function adjustSelection($selection,$db) {
    global $KM_minG;
    global $KM_minD;
    global $KM_minM;
    global $KM_minA;
    $countPoste=array('G'=>0,'D'=>0,'M'=>0,'A'=>0);
    $minPoste=array('G'=>$KM_minG,'D'=>$KM_minD,'M'=>$KM_minM,'A'=>$KM_minA);
    foreach ($selection as $sel) {
        $poste = $sel['poste'];
        if (($sel['sej_substitute'] == NULL || $sel['sej_substitute']==1) && $countPoste[$poste]<$minPoste[$poste]) {
            // Insérer cette nouvelle ligne de selection
            $insertQ="insert into km_selection_ekyp_journee(sej_engagement_id,sej_journee_id,sej_substitute) values ({$sel['eng_id']},{$sel['id']},0) on duplicate key update sej_substitute=0";
            $db->query($insertQ);
            $countPoste[$poste] = $countPoste[$poste]+1;
        } else if ($sel['sej_substitute']===0 && $countPoste[$poste]>$minPoste[$poste]) {
            // Enregistrement "en trop", à supprimer !
            $supprQ="delete from km_selection_ekyp_journee where sej_journee_id={$sel['id']} and sej_engagement_id={$sel['eng_id']}";
            $db->query($supprQ);
        }
        $countPoste[$poste] = $countPoste[$poste]+1;
    }
}
?>