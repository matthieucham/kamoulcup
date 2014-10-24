<?php
    include("accessManager.php");
    include("mercatoManager.php");
    include("franchiseManager.php");
    include("journeeManager.php");
    include("salaryManager.php");
    include("../model/KMConstants.php");
    include("../model/Resultat.php");

    checkPlayerAccess();
    
    $offers = $_POST['amountForPlayer'];
    $mercato = getCurrentMercato();
    
    if ($mercato == NULL) {
        echo fail("Le mercato est fermé");
        die();
    }

    if (isset($offers)) {
        $mercatoId = $mercato['mer_id'];
        $franchiseId = $_SESSION['myEkypId'];
        $journeeId = getLastJournee()['id'];
        
        $offPlayers=array();
        $offTotalAmount=0.0;
        $offTotalSalaires=0;
        foreach($offers as $playerId=>$amount) {
            array_push($offPlayers,$playerId);
            $offTotalAmount += $amount;
            $offTotalSalaires += getRealSalary($playerId,$journeeId);
        }
        $franchise = getFranchise($franchiseId);
        // 1 contrôle budget
        if ( round(floatval($franchise['fin_solde']),1) - $offTotalAmount < 0 ) {
            echo fail("Le montant des offres dépasse le budget");
            die();
        }
                
        // 2 contrôle salaire
        if (round(floatval($franchise['masseSalariale']),1)+$offTotalSalaires > $KM_maxSalary) {
            echo fail("Acheter ces joueurs ferait dépasser le plafond de masse salariale");
            die();
        }
        
        // 3 contrôle places dans l'effectif
        //TODO
        
        // 4 suppr des anciennes offres
        $removeQ = "delete from km_offre where off_mercato_id={$mercatoId} and off_ekyp_id={$franchiseId}";
        $db->query($removeQ);
        
        // 5 enregistrement des nouvelles offres
        foreach($offers as $playerId=>$amount) {
            $offQuery = "insert into km_offre(off_joueur_id,off_mercato_id,off_ekyp_id,off_montant) values ({$playerId},{$mercatoId},{$franchiseId},{$amount}) on duplicate key update off_montant={$amount}";
            $db->query($offQuery);
        }
        
        echo json_encode(new Resultat(true));
    }

    
    function fail($msg) {
        $res = new Resultat(false,msg);
        return json_encode($res);
    }

?>