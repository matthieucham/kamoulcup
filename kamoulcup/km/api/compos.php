<?php
    include("../model/model_include.php");
    include("../ctrl/compoManager.php");
    include("../ctrl/roundManager.php");

    $roundId = $_GET['roundid'];
    $franchiseId = $_GET['franchiseid'];

    $round=getRoundInfo($roundId);
    $compo = getActualCompo($franchiseId,$roundId);
    // Conversion du retour de la requête en objet JSON.
    $g=array();
    $d=array();
    $m=array();
    $a=array();
    $r=array();
    if ($compo != NULL) {
        foreach ($compo as $current) {
            $sco = round($current['jpe_score'],2);
            $player = new CompoPlayer($current['idJoueur'],$current['poste'],$current['prenom'].' '.$current['nomJoueur'],$current['nomClub'],$sco,$current['sro_selected']==1 && $current['sro_substitute']==1,$current['sro_selected']==0 && $current['sro_substitute']==0,$current['sro_sub_time']);
            if ($current['sro_selected']==0) {
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
    $composition = new Compo($g,$d,$m,$a,$r,$round['cro_numero']);

    echo json_encode($composition); 
?>