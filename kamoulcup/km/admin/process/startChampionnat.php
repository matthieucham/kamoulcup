<?php
    include("../../../includes/db.php");
    include("../../ctrl/accessManager.php");
    include('../../../process/validateForm.php');
    checkAdminAccess();

    $chpId = correctSlash($_POST['championnat']);

    // Initialisation des budgets
    $initBudgetQ = "insert into km_finances(fin_inscription_id,fin_date,fin_transaction,fin_solde,fin_event) select ins_id,now(),100.0,100.0,'Initialisation du budget' from km_inscription inner join km_championnat on ins_championnat_id=chp_id where chp_id={$chpId} and chp_status='CREATED'";
    $db->query($initBudgetQ);

    $startChpQ = "update km_championnat set chp_status='STARTED' where chp_id={$chpId} and chp_status='CREATED'";
    $db->query($startChpQ);

    header('Location: ../index.php');
	exit();
?>