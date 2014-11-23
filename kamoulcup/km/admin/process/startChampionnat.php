<?php
    include("../../../includes/db.php");
    include("../../ctrl/accessManager.php");
    include('../../../process/validateForm.php');
    checkAdminAccess();

    $chpId = correctSlash($_POST['championnat']);

    // Création des rounds
    // Récupération des caracs du championnat en cours
    $journeesQ = "select id,chp_first_journee_numero,chp_last_journee_numero from journee inner join km_championnat on chp_id={$chpId} where journee.numero in (chp_first_journee_numero,chp_last_journee_numero) group by numero";
    $journees = $db->getArray($journeesQ);
    if ($journees == NULL) {
        echo "Erreur : il faut creer les journees en premier";
        exit();
    }
    $nbAttendu = $journees[0][2]-$journees[0][1]+1;
    if ($nbAttendu != sizeof($journees)) {
        echo "Erreur : j attendais {$nbAttendu} journees";
        exit();
    }
    
    $num=1;
    foreach($journees as $j) {
        $roundQ = "insert into km_championnat_round(cro_championnat_id,cro_journee_id,cro_numero) values ({$chpId},{$j['id']},{$num})";
        $db->query($roundQ);
        $num++;
    }


    // Initialisation des budgets
    $initBudgetQ = "insert into km_finances(fin_inscription_id,fin_date,fin_transaction,fin_solde,fin_event) select ins_id,now(),100.0,100.0,'Initialisation du budget' from km_inscription inner join km_championnat on ins_championnat_id=chp_id where chp_id={$chpId} and chp_status='CREATED'";
    $db->query($initBudgetQ);
    

    $startChpQ = "update km_championnat set chp_status='STARTED' where chp_id={$chpId} and chp_status='CREATED'";
    $db->query($startChpQ);

    header('Location: ../index.php');
	exit();
?>