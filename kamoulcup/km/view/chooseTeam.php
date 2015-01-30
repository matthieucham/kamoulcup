<?php
    include('../ctrl/roundManager.php');
    include('../ctrl/compoManager.php');
    include('../ctrl/engagementManager.php');
    
    $franchiseId=$_SESSION['myFranchiseId'];
    $inscriptionId=$_SESSION['myInscriptionId'];
    $roundId=$_GET['roundid'];

    $round = getRoundInfo($roundId);
    $contrats = getContrats($inscriptionId);
// Trier les contrats par poste:
$joueurs=array('G'=>NULL,'D'=>NULL,'M'=>NULL,'A'=>NULL);

foreach ($contrats as $contrat) {
    $currPoste = $contrat['poste'];
    if ($joueurs[$currPoste] == NULL) {
        $joueurs[$currPoste] = array();
    }
    array_push($joueurs[$currPoste],$contrat);
}



$currentCompo = getSelectedCompo($franchiseId,$roundId,true);
$compoJoueurs = array('G'=>NULL,'D'=>NULL,'M'=>NULL,'A'=>NULL);
$subTimeJoueurs = array('G'=>NULL,'D'=>NULL,'M'=>NULL,'A'=>NULL);
$toHide = array();
if ($currentCompo != NULL) {
foreach ($currentCompo as $current) {
    $currPoste = $current['poste'];
    if ($compoJoueurs[$currPoste] == NULL) {
        $compoJoueurs[$currPoste] = array();
    }
    if ($subTimeJoueurs[$currPoste] == NULL) {
        $subTimeJoueurs[$currPoste] = array();
    }
    //echo $current['nomJoueur'].' '.$current['sub'].'<br/>';
    if ($current['sub']==0) {
        array_push($compoJoueurs[$currPoste],$current);
        array_push($toHide,$current['idJoueur']);
    } else if ($current['sro_sub_time']>0) {
        array_push($subTimeJoueurs[$currPoste],$current);
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

    function buildReservePlayer($j,$index) {
        $idVal=$j['idJoueur'];
        $nom=$j['prenom'].' '.$j['nomJoueur'].' ('.$j['nomClub'].')';
        echo "<div class='actionCompoPlayer'><i class='fa fa-minus-square'></i></div>";
        echo "<input type='hidden' name='reserve[{$index}]' value='{$idVal}'/>";
        echo "<p>{$nom}</p>";
    }


    function buildTituSlot($targetPos, $slotIndex, $index) {
        global $compoJoueurs;
        echo "<div id='compo{$targetPos}{$slotIndex}' class='compoPlayer' position='pos{$targetPos}'>";
        if ($compoJoueurs[$targetPos] != NULL && sizeof($compoJoueurs[$targetPos])>$slotIndex) {
            echo buildCompoPlayer($compoJoueurs[$targetPos][$slotIndex],$index);
        } else {
            echo "<input type='hidden' name='player[{$index}]' value=''/>";
        }  
        echo "</div>";
    }

    function buildReserveSlot($targetPos, $index) {
        global $subTimeJoueurs;
        echo "<div id='compoS{$targetPos}' class='subPlayer'>
                    <div class='compoSubPlayer' position='pos{$targetPos}'>";
            $selTime=0;
            if ($subTimeJoueurs[$targetPos] != NULL && sizeof($subTimeJoueurs[$targetPos])>0) {
                echo buildReservePlayer($subTimeJoueurs[$targetPos][0],$index);
                $selTime = $subTimeJoueurs[$targetPos][0]['sro_sub_time'];
            } else {
                 echo "<input type='hidden' name='reserve[{$index}]' value=''/>";
            }  
            echo "</div>
                <div class='subTime' title='Jouera si le titulaire joue moins de ... minutes'>";
            echo "<label for='selTime{$targetPos}'>Tps </label>
                <select id='selTime{$targetPos}' name='reservetime[$index]'>";
            $times = array(15,30,45,60);
            foreach($times as $t) {
                echo "<option value='{$t}' ";
                if ($t == $selTime) {
                    echo "selected";
                }
                echo ">{$t} min</option>";
            }
            echo "</select></div></div>";
    }
    
    function buildSubColumn($targetPos,$colName) {
        global $joueurs;
        global $toHide;
        echo "<div id='bench{$targetPos}' class='compoBenchPos'>
                <h3>{$colName}</h3>
                <ul>";
        if ($joueurs[$targetPos] != NULL) {
            foreach ($joueurs[$targetPos] as $j) {
                echo buildBenchPlayer($j,in_array($j['id'],$toHide));
            }
        }
        echo "</ul></div>";
    }

?>
<section id="chooseTeam">
<?php
echo "<h1>Compo pour le tour {$round['cro_numero']} </h1>";
?>
<h2>Instructions</h2>
<p>Placez les titulaires dans les cases blanches, soit par glisser-déposer, soit en cliquant sur le bouton "+"</p>
<p>Placez les remplaçants dans les cases jaunes (facultatif), et choisissez pour chacun le temps de jeu qui va déclencher son entrée. Soit N le temps de jeu choisi :
</p>
    <ul>
        <li>Si le titulaire joue strictement moins de N minutes et que le remplaçant désigné a joué N minutes ou plus, le remplaçant prend sa place</li>
        <li>Dans tous les autres cas, le titulaire n'est pas remplacé.</li>
    </ul>
<p>Quand vous avez fini, enregistrez !</p>

<div id="pitchBench">
    <form id="compoForm">
    <div id="compo">
            <?php
                echo "<input type='hidden' name='franchiseid' value='{$franchiseId}'/>";
                echo "<input type='hidden' name='roundid' value='{$roundId}'/>";
                buildTituSlot('G',0,0);
                buildTituSlot('D',0,1);
                buildTituSlot('D',1,2);
                buildTituSlot('M',0,3);
                buildTituSlot('M',1,4);
                buildTituSlot('A',0,5);
                buildTituSlot('A',1,6);

            buildReserveSlot('G',0);
            buildReserveSlot('D',1);
            buildReserveSlot('M',2);
            buildReserveSlot('A',3);
        ?>
    </div>
    <h2>Banc de touche</h2>
    <div id="compoBench">
        <?php
            buildSubColumn('G','Gardiens');
            buildSubColumn('D','Défenseurs');
            buildSubColumn('M','Milieux');
            buildSubColumn('A','Attaquants');
        ?>
        </div>
    </form>
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