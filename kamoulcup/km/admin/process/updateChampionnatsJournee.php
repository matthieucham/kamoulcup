<?php
include("../../../includes/db.php");
include("../../ctrl/accessManager.php");
include('../../../process/validateForm.php');
checkAdminAccess();

$journeeId = correctSlash($_POST['journee']);

	// 	1) Récupérer la date de la journée choisie
	$selectDateQ = $db->getArray("select date,numero from journee where id={$journeeId}");
	$jDate = $selectDateQ[0][0];
    $jNumero = $selectDateQ[0][1];

    if (strtotime($jDate)>time() ) {
        // Trop tôt
        echo "La journée n'a pas encore eu lieu.";
        die();
    }

    $selectPreviousDate = $db->getArray("select id from journee where date<str_to_time({$jDate}) order by date desc limit 1");
    $previousJourneeId = 0;
    if ($selectPreviousDate != NULL && sizeof($selectPreviousDate==1)) {
        $previousJourneeId = $selectPreviousDate[0][0];
    }


// Algo:
// 1- On essaye de prendre la compo rentrée par les joueurs. On y exclue les joueurs qui ne sont plus sous contrat
// 2- Si pas de compo, on prend celle de la journée d'avant. Même exclusion.
// 3- On remplace tous les trous par les joueurs sous contrat hors compo par ordre décroissant de salaire.

    $cleanCompoQ = "delete from km_selection_round where sro_round_id in (select cro_id from km_championnat_round where cro_journee_id={$journeeId}) and sro_engagement_id in (select eng_id from km_engagement inner join journee on id={$journeeId} where (date<=eng_date_arrivee) or (date>eng_date_depart))";
// Cela vide les sej invalides pour toutes les franchises à la fois, sur tous les championnats :
    $db->query($cleanCompoQ);

// 1 on récupére tous les championnats concernés par la journée écoulée
// 2 on récupère toutes les franchises de ces championnats
// OLD (facile) $franchisesQ = "select id from ekyp where km=1";
$franchisesQ = "select ins_id,cro_id from km_inscription inner join km_championnat_round on ins_championnat_id=cro_championnat_id where cro_journee_id={$journeeId}";

$inscriptions = $db->getArray($franchisesQ);

if ($inscriptions != NULL) {
    foreach ($inscriptions as $fr) {
    // On regarde si l'utilisateur a bien pensé (ou du moins essayé) à enregistrer sa compo. S'il n'a rien fait, on recopie la compo de la journée d'avant.
        $existingCompoQ = "select count(sro_engagement_id) from km_selection_round inner join km_engagement on sro_engagement_id=eng_id inner join km_championnat_round on cro_id=sro_round_id inner join journee on journee.id=cro_journee_id where cro_journee_id={$journeeId} and eng_inscription_id={$fr['ins_id']}";
        $cE = $db->getArray($existingCompoQ);
        $compoExists = intval($cE[0][0])>0;
        if (!compoExists && $previousJourneeId>0) {
        // Recopier les engagements (valides) de la journée d'avant.
            $copyQ = "insert into km_selection_round(sro_engagement_id,sro_round_id,sro_substitute) select sro_engagement_id, t2.cro_id,sro_substitute from km_selection_round inner join km_engagement on eng_id=sro_engagement_id inner join km_championnat_round t1 on t1.cro_id=sro_round_id inner join journee on journee.id={$journeeId} inner join km_championnat_round t2 on journee.id=t2.cro_journee_id where (date>=eng_date_arrivee) and (date<eng_date_depart or eng_date_depart IS NULL) and eng_inscription_id={$fr['ins_id']} and t1.cro_journee_id={$previousJourneeId}";
            $db->query($copyQ);
        }
    
        $possibleCompoQ = "select cro_id,joueur.poste,eng_id,sro_substitute from km_engagement inner join joueur on eng_joueur_id=joueur.id inner join km_championnat_round on cro_journee_id={$journeeId} inner join journee on cro_journee_id=journee.id left outer join km_selection_round on sro_round_id=cro_id and sro_engagement_id=eng_id where (date>=eng_date_arrivee) and (date<eng_date_depart or eng_date_depart IS NULL) and eng_inscription_id={$fr['ins_id']} order by field(poste,'G','D','M','A'),sro_substitute,eng_salaire desc, eng_date_arrivee desc";
    // ATTENTION BUG A CORRIGER : les substitute "0" sont forcément avant les "NULL" : erreur !
        $selection=$db->getArray($possibleCompoQ);
        if ($selection != NULL) {
            adjustSelection($selection,$db);
        }
    }
    
    // Update flag cro_status to PROCESSED
    $processedRounds = array();
    foreach ($inscriptions as $ins) {
            if ( !in_array($ins['cro_id'],$processedRounds)) {
                array_push($processedRounds,$ins['cro_id']);
            }
    }
    $expl = implode(",",$processedRounds);
    $db->query("update km_championnat_round set cro_status='PROCESSED' where cro_id in ({$expl})");
}



// calculer les points marqués par chaque ekyp de chaque championnat concerné par la journée passée en param.
    $franchiseScoreQ = "select eng_inscription_id,cro_id,sum(jpe_score) as score FROM km_joueur_perf inner join km_engagement on eng_joueur_id=jpe_joueur_id inner join km_selection_round on sro_engagement_id=eng_id inner join rencontre on jpe_match_id=rencontre.id inner join journee on rencontre.journee_id=journee.id inner join km_championnat_round on journee.id=cro_journee_id and cro_id=sro_round_id inner join km_inscription on ins_id=eng_inscription_id where journee.id={$journeeId} and sro_substitute=0 and cro_status='PROCESSED' group by eng_inscription_id,cro_id";

$updateScoreQ = "insert into km_franchise_score(fsc_inscription_id,fsc_round_id,fsc_score) {$franchiseScoreQ} on duplicate key update fsc_score=values(fsc_score)";

$db->query($updateScoreQ);



	header('Location: ../index.php');
	exit();



function adjustSelection($selection,$db) {
    global $KM_minG;
    global $KM_minD;
    global $KM_minM;
    global $KM_minA;
    $countPoste=array('G'=>0,'D'=>0,'M'=>0,'A'=>0);
    $minPoste=array('G'=>$KM_minG,'D'=>$KM_minD,'M'=>$KM_minM,'A'=>$KM_minA);
    foreach ($selection as $sel) {
        $poste = $sel['poste'];
        if (($sel['sro_substitute'] == NULL || $sel['sro_substitute']==1) && $countPoste[$poste]<$minPoste[$poste]) {
            // Insérer cette nouvelle ligne de selection
            $insertQ="insert into km_selection_round(sro_engagement_id,sro_round_id,sro_substitute) values ({$sel['eng_id']},{$sel['cro_id']},0) on duplicate key update sro_substitute=0";
            $db->query($insertQ);
            $countPoste[$poste] = $countPoste[$poste]+1;
        } else if ($sel['sro_substitute']==0 && $countPoste[$poste]>=$minPoste[$poste]) {
            // Enregistrement "en trop", à supprimer !
            $supprQ="insert into km_selection_round(sro_engagement_id,sro_round_id,sro_substitute) values ({$sel['eng_id']},{$sel['cro_id']},1) on duplicate key update sro_substitute=1";
            $db->query($supprQ);
        } else {
            if ($sel['sro_substitute']==0) {
                // C'est un titulaire valide qui fait augmenter le compteur.
                $countPoste[$poste] = $countPoste[$poste]+1;
            }
        }
    }
}
?>