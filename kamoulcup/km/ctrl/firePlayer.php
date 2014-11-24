<?php
    include("accessManager.php");
    include("mercatoManager.php");
    include("transferManager.php");

    checkPlayerAccess();

    // Si le joueur est déjà listé, il ne faut pas qu'un mercato soit en cours
    $joueurId =  $_POST['playerid'];
    $insId = $_SESSION['myInscriptionId'];


    if (isListed($joueurId) && getCurrentMercato() != NULL) {
        echo "ERREUR : JOUEUR EN VENTE ET MERCATO EN COURS";
        die();
    }

    $fireQ = "update km_engagement set eng_date_depart=now() where eng_joueur_id={$joueurId} and eng_inscription_id={$insId} and eng_date_depart IS NULL";

    $db->query($fireQ);

    header('Location: ../view/index.php?kmpage=team');
    die();
?>