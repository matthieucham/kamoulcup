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
    $amount = round(floatval($_POST['sellValue'][$joueurId]),1);

    // Verifier amount
    if ($amount < 0.1) {
        echo "MONTANT INCORRECT";
        die();
    }

    $listQ = "insert into km_liste_transferts(ltr_engagement_id,ltr_montant) select eng_id,{$amount} from km_engagement where eng_joueur_id={$joueurId} and eng_ekyp_id={$franchiseId} and eng_date_depart IS NULL on duplicate key update ltr_montant={$amount}";

    $db->query($listQ);

    header('Location: ../view/index.php?kmpage=team');
    die();
?>