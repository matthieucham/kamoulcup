<?php
    include("accessManager.php");
    include("../../includes/db.php");
    checkPlayerAccess();

    $joueurId =  $_POST['playerid'];
    $franchiseId = $_SESSION['myEkypId'];

    $fireQ = "update km_engagement set eng_date_depart=now() where eng_joueur_id={$joueurId} and eng_ekyp_id={$franchiseId} and eng_date_depart IS NULL";

    $db->query($fireQ);

    header('Location: ../view/index.php?kmpage=team');
    die();
?>