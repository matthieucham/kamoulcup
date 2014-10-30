<?php
    include("../model/model_include.php");
    include("../ctrl/compoManager.php");
    include("../ctrl/journeeManager.php");

    $journeeId = $_GET['journeeid'];
    $franchiseId = $_GET['franchiseid'];

    $journee=getJournee($journeeId);
    $compo = getCompo($franchiseId,$journeeId);
    // Conversion du retour de la requête en objet JSON.
    $g=array();
    $d=array();
    $m=array();
    $a=array();
    $r=array();
    if ($compo != NULL) {
        foreach ($compo as $current) {
            $sco = round($current['jpe_score'],2);
            $player = new CompoPlayer($current['idJoueur'],$current['poste'],$current['prenom'].' '.$current['nomJoueur'],$current['nomClub'],$sco);
            if ($current['sub']==1) {
                array_push($r,$player);
            } else {
                if ($player->position=='G') {
                    array_push($g,$player);
                } else if ($player->position=='D') {
                    array_push($d,$player);
                } else if ($player->position=='M') {
                    array_push($m,$player);
                } else if ($player->position=='A') {
                    array_push($a,$player);
                }
            }
        }
    }
    $composition = new Compo($g,$d,$m,$a,$r,$journee['numero']);

    echo json_encode($composition); 
?>