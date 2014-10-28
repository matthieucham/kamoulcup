<?php
    include("accessManager.php");
    include("mercatoManager.php");

    checkPlayerAccess();
    if (getCurrentMercato() != NULL) {
        echo "ERREUR : MERCATO EN COURS";
        die();
    }

    $joueurId =  $_POST['playerid'];
    $franchiseId = $_SESSION['myEkypId'];

    $listQ = "delete from km_liste_transferts where ltr_engagement_id in (select eng_id from km_engagement where eng_joueur_id={$joueurId} and eng_ekyp_id={$franchiseId} and eng_date_depart IS NULL)";

    $db->query($listQ);

    header('Location: ../view/index.php?kmpage=team');
    die();
?>