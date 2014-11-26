<?php
    include("accessManager.php");
    include("mercatoManager.php");
    include("franchiseManager.php");
    include("joueurManager.php");
    
    include("../model/KMConstants.php");
    include("../model/Resultat.php");

    checkPlayerAccess();
    
    $offers = $_POST['amountForPlayer'];
    $mercato = getCurrentMercato($_SESSION['myChampionnatId']);
    
    if ($mercato == NULL) {
        echo fail("Le mercato est fermé");
        die();
    }

    if (isset($offers)) {
        $mercatoId = $mercato['mer_id'];
        //$franchiseId = $_SESSION['myFranchiseId'];
        $inscriptionId = $_SESSION['myInscriptionId'];
        
        $offPlayers=array();
        $offTotalAmount=0.0;
        $offTotalSalaires=0;
        foreach($offers as $playerId=>$amount) {
            array_push($offPlayers,$playerId);
            $offTotalAmount += $amount;
            $joueurInfo=getJoueurCommonInfo($playerId);
            $offTotalSalaires += $joueurInfo['scl_salaire'];
        }
        $franchise = getFranchise($inscriptionId);
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
        $removeQ = "delete from km_offre where off_mercato_id={$mercatoId} and off_inscription_id={$inscriptionId}";
        $db->query($removeQ);
        
        // 5 enregistrement des nouvelles offres
        foreach($offers as $playerId=>$amount) {
            $offQuery = "insert into km_offre(off_joueur_id,off_mercato_id,off_inscription_id,off_montant) values ({$playerId},{$mercatoId},{$inscriptionId},{$amount}) on duplicate key update off_montant={$amount}";
            $db->query($offQuery);
        }
        
        echo json_encode(new Resultat(true));
    }

    
    function fail($msg) {
        $res = new Resultat(false,msg);
        return json_encode($res);
    }

?>