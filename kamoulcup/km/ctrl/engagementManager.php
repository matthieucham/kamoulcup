<?php
include_once("../../includes/db.php");

function getContrats($inscriptionId) {
    global $db;
    $contratsQ="select joueur.id,joueur.prenom,joueur.nom as nomJoueur,joueur.poste,club.nom as nomClub,eng_montant,eng_salaire from joueur inner join km_engagement on joueur.id=eng_joueur_id inner join club on joueur.club_id=club.id where eng_inscription_id={$inscriptionId} and eng_date_depart IS NULL order by field(poste,'G','D','M','A')";
    return $db->getArray($contratsQ);
}


function hasContratWithFranchise($joueurId,$inscriptionId) {
    global $db;
    $contratQ="select count(eng_id) from km_engagement where eng_inscription_id={$inscriptionId} and eng_joueur_id={$joueurId} and eng_date_depart IS NULL";
    $res = $db->getArray($contratQ);
    return intval($res[0][0])>0;
}
?>