<?php
// Produit un JSON contenant les offres en cours de la franchise connectée
include_once("../model/model_include.php");
include_once("../../includes/db.php");

include_once("../ctrl/mercatoManager.php");

session_start();
//$franchiseId = $_SESSION['myEkypId'];
$inscriptionId = $_SESSION['myInscriptionId'];
$champId = $_SESSION['myChampionnatId'];

$mercato=getCurrentMercato($champId);
if ($mercato==NULL) {
    echo "Erreur, pas de mercato en cours";
    die();
}
$mercatoId=$mercato['mer_id'];


$offresCourantesQ="select joueur.id,nom,prenom,poste,off_montant,scl_salaire,ltr_montant from joueur inner join km_offre on off_joueur_id=joueur.id and off_inscription_id={$inscriptionId} and off_mercato_id={$mercatoId} inner join km_join_joueur_salaire on jjs_joueur_id=joueur.id inner join km_const_salaire_classe on jjs_salaire_classe_id=scl_id inner join journee on jjs_journee_id=journee.id left outer join km_engagement on eng_joueur_id=joueur.id and eng_date_depart is null left outer join km_liste_transferts on ltr_engagement_id=eng_id order by journee.date desc limit 1";
$offresCourantes=$db->getArray($offresCourantesQ);

$offers = array();
if ($offresCourantes != NULL) {
    // Retourner une liste de Player ayant une offre.
    foreach($offresCourantes as $currentJoueur) {
        $trValue = 0;
        if ($currentJoueur['ltr_montant'] != NULL) {
            $trValue = floatVal($currentJoueur['ltr_montant']);
        }
        $player = new Player($currentJoueur['id'], $currentJoueur['prenom'].' '.$currentJoueur['nom'],floatval($currentJoueur['scl_salaire']),$trValue,$currentJoueur['poste']);
        $player->offer=floatval($currentJoueur['off_montant']);
        array_push($offers,$player);
    }
}

echo json_encode($offers);

?>