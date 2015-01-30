<?php
    include("accessManager.php");
    include("compoManager.php");
    include("journeeManager.php");
    include("engagementManager.php");
    include("inscriptionManager.php");
    include("../model/Resultat.php");

    checkPlayerAccess();
    
    $players = $_POST['player'];
    $reserve = $_POST['reserve'];
    $reserveTime = $_POST['reservetime'];
    $roundId = $_POST['roundid'];
    $franchiseId = $_POST['franchiseid'];
    $subs = $_POST['sub'];
    $inscription = getInscriptionFromRound($franchiseId,$roundId);

    // Vérifier que la journee n'est pas commencée
    $journee = getJourneeFromRound($roundId);
    if (strtotime($journee['date']) <time() ) {
        // Trop tard
        echo fail('La journée a déjà commencé, impossible de la modifier');
        die();
    }

    clearCompo($franchiseId,$roundId);

    $validIds=array();
    if (isset($players)) {
        // Vérifier que tous les joueurs sont sous contrat avec la franchise
        foreach($players as $playerId) {
            if ($playerId != NULL) {
                if (! hasContratWithFranchise($playerId,$inscription['ins_id'])) {
                    echo fail("Un joueur n'est plus sous contrat avec cette franchise");
                    die();
                }
                array_push($validIds,$playerId);
            }
        }
        saveCompo($franchiseId,$roundId,$validIds,0);
    }
    if (isset($subs)) {
        $subIds = array();
        foreach($subs as $k=>$v) {
            if ($v == 1) {
                if (! hasContratWithFranchise($k,$inscription['ins_id'])) {
                    echo fail("Un joueur n'est plus sous contrat avec cette franchise");
                    die();
                }
                array_push($subIds,$k);
            }
        }
        saveCompo($franchiseId,$roundId,$subIds,1);
    }
    if (isset($reserve)) {
        $i=0;
        foreach($reserve as $playerId) {
            if ($playerId != NULL) {
                if (! hasContratWithFranchise($playerId,$inscription['ins_id'])) {
                    echo fail("Un joueur n'est plus sous contrat avec cette franchise");
                    die();
                }
                $time = $reserveTime[$i];
                saveReserve($franchiseId,$roundId,$playerId,$time);
            }
            $i++;
        }
    }
    echo json_encode(new Resultat(true));   

    function fail($msg) {
        $res = new Resultat(false,$msg);
        return json_encode($res);
    }

?>