<?php
include_once("../../includes/db.php");

function getContrats($franchiseId) {
    global $db;
    $contratsQ="select joueur.id,joueur.prenom,joueur.nom as nomJoueur,joueur.poste,club.nom as nomClub from joueur inner join km_engagement on joueur.id=eng_joueur_id inner join club on joueur.club_id=club.id where eng_ekyp_id={$franchiseId} and eng_date_depart IS NULL";
    return $db->getArray($contratsQ);
}

?>