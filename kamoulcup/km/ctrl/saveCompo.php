<?php
    include("accessManager.php");
    include("compoManager.php");
    include("journeeManager.php");
    include("engagementManager.php");
    include("../model/Resultat.php");

    checkPlayerAccess();
    
    $players = $_POST['player'];
    $journeeId = $_POST['journeeid'];
    $franchiseId = $_POST['franchiseid'];
    $subs = $_POST['sub'];

    // Vérifier que la journee n'est pas commencée
    $journee = getJournee($journeeId);
    if (strtotime($journee['date']) <time() ) {
        // Trop tard
        echo fail('La journée a déjà commencé, impossible de la modifier');
        die();
    }

    clearCompo($franchiseId,$journeeId);

    $validIds=array();
    if (isset($players)) {
        // Vérifier que tous les joueurs sont sous contrat avec la franchise
        foreach($players as $playerId) {
            if ($playerId != NULL) {
                if (! hasContratWithFranchise($playerId,$franchiseId)) {
                    echo fail("Un joueur n'est plus sous contrat avec cette franchise");
                    die();
                }
                array_push($validIds,$playerId);
            }
        }
        saveCompo($franchiseId,$journeeId,$validIds,0);
     echo json_encode(new Resultat(true));   
    }
    if (isset($subs)) {
        $subIds = array();
        foreach($subs as $k=>$v) {
            if ($v == 1) {
                if (! hasContratWithFranchise($k,$franchiseId)) {
                    echo fail("Un joueur n'est plus sous contrat avec cette franchise");
                    die();
                }
                array_push($subIds,$k);
            }
        }
        saveCompo($franchiseId,$journeeId,$subIds,1);
    }

    
    function fail($msg) {
        $res = new Resultat(false,$msg);
        return json_encode($res);
    }

?>