<?php
    include("accessManager.php");
    include("mercatoManager.php");
    include("../model/Resultat.php");

    checkPlayerAccess();
    
    $offers = $_POST['amountForPlayer'];
    $mercato = getCurrentMercato();
    
    if ($mercato == NULL) {
        echo json_encode(fail("Le mercato est fermé"));
        die();
    }

    if (isset($offers)) {
        $mercatoId = $mercato['mer_id'];
        $franchiseId = $_SESSION['myEkypId'];
        
        $offPlayers=array();
        $offTotalAmount=0.0;
        foreach($offers as $playerId=>$amount) {
            array_push($offPlayers,$playerId);
            $offTotalAmount += $amount;
        }
        // 1 contrôle budget
        //TODO
                
        // 2 contrôle salaire
        //TODO
        
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