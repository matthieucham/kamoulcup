<?php
session_start();
include("../model/model_include.php");
include("../ctrl/mercatoManager.php");

$champId = $_SESSION['myChampionnatId'];
$mercato = getCurrentMercato($champId);

$clubsQ = "select id, nom from club order by nom asc";
$clubs = $db->getArray($clubsQ);

$data = array();
foreach($clubs as $currentClub) {
    $clubId = $currentClub['id'];
    $joueursQ = "select jo.id, jo.prenom, jo.nom, jo.poste, scl_salaire, max(eng_id) as idEngagement, max(ltr_montant) as montant from joueur jo inner join km_join_joueur_salaire on jo.id=jjs_joueur_id inner join km_const_salaire_classe on scl_id=jjs_salaire_classe_id inner join km_inscription on ins_championnat_id={$champId} inner join km_mercato on mer_id={$mercato['mer_id']} left outer join km_engagement on eng_joueur_id=jo.id  and eng_inscription_id=ins_id and (eng_date_depart is null or eng_date_depart>mer_date_ouverture) left outer join km_liste_transferts on eng_id=ltr_engagement_id where jo.club_id={$clubId} and jjs_journee_id=(select jjs_journee_id from km_join_joueur_salaire inner join journee on journee.id=jjs_journee_id order by date desc limit 1) group by jo.id order by field(jo.poste,'G','D','M','A'), jo.nom, eng_montant desc ";
    $joueursClub = $db->getArray($joueursQ);
    $effectifClub = array();
    if ($joueursClub != NULL) {
    foreach($joueursClub as $currentJoueur) {
        $trValue = 0;
        if ($currentJoueur['montant'] != NULL) {
            $trValue = floatval($currentJoueur['ltr_montant']);
        } else if ($currentJoueur['idEngagement'] != NULL) {
            $trValue = -1;
        }
        array_push($effectifClub, new Player($currentJoueur['id'], $currentJoueur['prenom'].' '.$currentJoueur['nom'],floatval($currentJoueur['scl_salaire']),floatval($trValue),$currentJoueur['poste']));
    }
    }
    array_push($data,new Club($clubId,$currentClub['nom'],$effectifClub));
}

echo json_encode($data);

?>
