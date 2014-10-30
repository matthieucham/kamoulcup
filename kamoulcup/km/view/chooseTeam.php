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
// TODO croiser avec contrats.

    function buildBenchPlayer($j) {
        return "<li class='benchPlayer' id='bp_{$j['id']}'>{$j['prenom']} {$j['nomJoueur']} ({$j['nomClub']})<input type='hidden' name='playerid' value='{$j['id']}'/></li>";
    }
?>
<section id="chooseTeam">
<?php
echo "<h1>Compo pour la journée {$journee['numero']}</h1>";
?>
<p>Sélectionnez les titulaires par "glisser-déposer" depuis le banc de touche</p>
    <div id="compo">
        <form method="post">
            <div id="compoG" class="compoPlayer" position="posG">
                <input type="hidden" name="player[0]" value=""/>
            </div>
            <div id="compoD1" class="compoPlayer" position="posD">
                <input type="hidden" name="player[1]" value=""/>
            </div>
            <div id="compoD2" class="compoPlayer" position="posD">
                <input type="hidden" name="player[2]" value=""/>
            </div>
            <div id="compoM1" class="compoPlayer" position="posM">
                <input type="hidden" name="player[3]" value=""/>
            </div>
            <div id="compoM2" class="compoPlayer" position="posM">
                <input type="hidden" name="player[4]" value=""/>
            </div>
            <div id="compoA1" class="compoPlayer" position="posA">
                <input type="hidden" name="player[5]" value=""/>
            </div>
            <div id="compoA2" class="compoPlayer" position="posA">
                <input type="hidden" name="player[6]" value=""/>
            </div>
        </form>
    </div>
    <h2>Banc de touche</h2>
    <div id="compoBench">
            <div id='benchG' class="compoBenchPos">
                <h3>Gardiens</h3>
                <ul>
<?php
    if ($joueurs['G'] != NULL) {
        foreach ($joueurs['G'] as $j) {
            echo buildBenchPlayer($j);
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
            echo buildBenchPlayer($j);
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
            echo buildBenchPlayer($j);
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
            echo buildBenchPlayer($j);
        }
    }
?>
                </ul>
            </div>
    </div>
</section>
<script src="js/custom/km-chooseTeam.js"></script>