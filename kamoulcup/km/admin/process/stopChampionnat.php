<?php
    include("../../../includes/db.php");
    include("../../ctrl/accessManager.php");
    include('../../../process/validateForm.php');
    checkAdminAccess();

    $chpId = correctSlash($_POST['championnat']);

    // Comptage des journées processées (on ne  peut pas terminer tant que tout n'est pas joué)
    $verifQ = "select count(cro_id),chp_first_journee_numero,chp_last_journee_numero from km_championnat_round inner join km_championnat on cro_championnat_id=chp_id where chp_id={$chpId} and cro_status='PROCESSED'";
    $verif = $db->getArray($verifQ);
    if ($verif[0][0] != ($verif[0][2]-$verif[0][1] + 1)) {
        echo "Impossible de terminer le championnat : toutes les journées ne sont pas traitées.";
        exit();
    }

    // Insertion du palmarès
    // TODO !

    // archivage des rounds
    $archiveQ = "update km_championnat_round set cro_status='ARCHIVED' where cro_championnat_id={$chpId} and cro_status='PROCESSED'";
    $db->query($archiveQ);

    // cloture du championnat
    $stopChpQ = "update km_championnat set chp_status='FINISHED' where chp_id={$chpId} and chp_status='STARTED'";
    $db->query($stopChpQ);

    header('Location: ../index.php');
	exit();
?>