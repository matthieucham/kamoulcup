<?php
    include('../ctrl/journeeManager.php');
    include('../ctrl/compoManager.php');
    include('../ctrl/engagementManager.php');
    
    $franchiseId=$_SESSION['myEkypId'];
    $journeeId=$_GET['journeeid'];

    $journee = getJournee($journeeId);
    $contrats = getContrats($franchiseId);
// Trier les contrats par poste:
$joueurs=array('G'=>NULL,'D'=>NULL,'M'=>NULL,'A'=>NULL);

foreach ($contrats as $contrat) {
    $currPoste = $contrat['poste'];
    if ($joueurs[$currPoste] == NULL) {
        $joueurs[$currPoste] = array();
    }
    array_push($joueurs[$currPoste],$contrat);
}



$currentCompo = getCompoNoScore($franchiseId,$journeeId,true);
$compoJoueurs = array('G'=>NULL,'D'=>NULL,'M'=>NULL,'A'=>NULL);
$toHide = array();
if ($currentCompo != NULL) {
foreach ($currentCompo as $current) {
    $currPoste = $current['poste'];
    if ($compoJoueurs[$currPoste] == NULL) {
        $compoJoueurs[$currPoste] = array();
    }
    //echo $current['nomJoueur'].' '.$current['sub'].'<br/>';
    if ($current['sub']==0) {
        array_push($compoJoueurs[$currPoste],$current);
        array_push($toHide,$current['idJoueur']);
    }
}    
}
    function buildBenchPlayer($j,$hide) {
        $hideClass='';
        $subVal=1;
        if ($hide) {
            $hideClass=' hide';
            $subVal=0;
        }
        return "<li class='benchPlayer{$hideClass}' id='bp_{$j['id']}' position='pos{$j['poste']}'><div class='actionCompoPlayer'><i class='fa fa-plus-square'></i></div>{$j['prenom']} {$j['nomJoueur']} ({$j['nomClub']})<input type='hidden' name='playerid' value='{$j['id']}'/><input type='hidden' name='sub[{$j['id']}]' value='{$subVal}'/></li>";
    }

    function buildCompoPlayer($j,$index) {
        $idVal=$j['idJoueur'];
        $nom=$j['prenom'].' '.$j['nomJoueur'].' ('.$j['nomClub'].')';
        echo "<div class='actionCompoPlayer'><i class='fa fa-minus-square'></i></div>";
        echo "<input type='hidden' name='player[{$index}]' value='{$idVal}'/>";
        echo "<p>{$nom}</p>";
    }
?>
<section id="chooseTeam">
<?php
echo "<h1>Compo pour la journée {$journee['numero']}</h1>";
?>
<p>Sélectionnez les titulaires par "glisser-déposer" depuis le banc de touche</p>
<div id="pitchBench">
    <form id="compoForm">
    <div id="compo">
            <?php
                echo "<input type='hidden' name='franchiseid' value='{$franchiseId}'/>";
                echo "<input type='hidden' name='journeeid' value='{$journeeId}'/>";
            ?>
            <div id="compoG" class="compoPlayer" position="posG">
                <?php
                    if ($compoJoueurs['G'] != NULL && sizeof($compoJoueurs['G'])>0) {
                        echo buildCompoPlayer($compoJoueurs['G'][0],0);
                    } else {
                        echo "<input type='hidden' name='player[0]' value=''/>";
                    }  
                ?>
            </div>
            <div id="compoD1" class="compoPlayer" position="posD">
                <?php
                    if ($compoJoueurs['D'] != NULL && sizeof($compoJoueurs['D'])>0) {
                        echo buildCompoPlayer($compoJoueurs['D'][0],1);
                    } else {
                        echo "<input type='hidden' name='player[1]' value=''/>";
                    }  
                ?>
            </div>
            <div id="compoD2" class="compoPlayer" position="posD">
                <?php
                    if ($compoJoueurs['D'] != NULL && sizeof($compoJoueurs['D'])>1) {
                        echo buildCompoPlayer($compoJoueurs['D'][1],2);
                    } else {
                        echo "<input type='hidden' name='player[2]' value=''/>";
                    }  
                ?>
            </div>
            <div id="compoM1" class="compoPlayer" position="posM">
                <?php
                    if ($compoJoueurs['M'] != NULL && sizeof($compoJoueurs['M'])>0) {
                        echo buildCompoPlayer($compoJoueurs['M'][0],3);
                    } else {
                        echo "<input type='hidden' name='player[3]' value=''/>";
                    }  
                ?>                
            </div>
            <div id="compoM2" class="compoPlayer" position="posM">
                <?php
                    if ($compoJoueurs['M'] != NULL && sizeof($compoJoueurs['M'])>1) {
                        echo buildCompoPlayer($compoJoueurs['M'][1],4);
                    } else {
                        echo "<input type='hidden' name='player[4]' value=''/>";
                    }  
                ?>  
            </div>
            <div id="compoA1" class="compoPlayer" position="posA">
                <?php
                    if ($compoJoueurs['A'] != NULL && sizeof($compoJoueurs['A'])>0) {
                        echo buildCompoPlayer($compoJoueurs['A'][0],5);
                    } else {
                        echo "<input type='hidden' name='player[5]' value=''/>";
                    }  
                ?>                  
            </div>
            <div id="compoA2" class="compoPlayer" position="posA">
                <?php
                    if ($compoJoueurs['A'] != NULL && sizeof($compoJoueurs['A'])>1) {
                        echo buildCompoPlayer($compoJoueurs['A'][1],6);
                    } else {
                        echo "<input type='hidden' name='player[6]' value=''/>";
                    }  
                ?>                  
            </div>
    </div>
    <h2>Banc de touche</h2>
    <div id="compoBench">
            <div id='benchG' class="compoBenchPos">
                <h3>Gardiens</h3>
                <ul>
<?php
    if ($joueurs['G'] != NULL) {
        foreach ($joueurs['G'] as $j) {
            echo buildBenchPlayer($j,in_array($j['id'],$toHide));
        }
    }
?>
                </ul>
            </div>
            <div id='benchD' class="compoBenchPos">
                <h3>Défenseurs</h3>
                <ul>
 <?php
    if ($joueurs['D'] != NULL) {
        foreach ($joueurs['D'] as $j) {
            echo buildBenchPlayer($j,in_array($j['id'],$toHide));
        }
    }
?>
                </ul>
            </div>
            <div id='benchM' class="compoBenchPos">
                <h3>Milieux</h3>
                <ul>
<?php
    if ($joueurs['M'] != NULL) {
        foreach ($joueurs['M'] as $j) {
            echo buildBenchPlayer($j,in_array($j['id'],$toHide));
        }
    }
?>
                </ul>
            </div>
            <div id='benchA' class="compoBenchPos">
                <h3>Attaquants</h3>
                <ul>
<?php
    if ($joueurs['A'] != NULL) {
        foreach ($joueurs['A'] as $j) {
            echo buildBenchPlayer($j,in_array($j['id'],$toHide));
        }
    }
?>
                </ul>
            </div>
        </form>
    </div>
</div>
<div id="actions">
    <button id="registerBtn">Enregistrer</button>
        <div id='registerResult'>
            <div class='uppings hide'><p><i class="fa fa-thumbs-up fa-2x"></i> Compo enregistrée</p></div>
            <div class='downings hide'><p><i class="fa fa-warning fa-2x"></i> </p></div>
        </div>
</div>

<div id="registerPopup" class="popup hide">
<div class="cover"></div>
<div class="frame">
    <p><i class="fa fa-spinner fa-spin"></i> Enregistrement...</p>
</div>
</div>
</section>
<script src="js/custom/km-chooseTeam.js"></script>