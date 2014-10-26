<?php
    include_once('../ctrl/joueurManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/transferManager.php');

	if (! isset($_GET['joueurid'])) {
		echo '<p class=\"error\">Pas de JoueurId !</p>';
		exit;
	}
	$joueurId = ($_GET['joueurid']);
    $lastJournee = getLastJournee();
    $joueur = getJoueur($joueurId,$lastJournee['id']);
?>

<section id="player">
    <?php
	echo "<div class='sectionInfo'>
        <h2>{$joueur['prenom']} {$joueur['nomJoueur']}</h2>
		<p><span class='playerPosition'>{$joueur['poste']}</span> <a href='./index.php?page=detailClub&clubid={$joueur['idClub']}'>{$joueur['nomClub']}</a></p>
	   </div>";
    ?>
<div id="timeline">
	<div id="cd-timeline" class="cd-container">
		<!-- Présentation sous forme de timeline -->
        <?php
        $transfers = listPlayerTransfers($joueurId);
        if ($transfers != NULL) {
            $lastDateArrivee = NULL;
            foreach ($transfers as $tr) {
                $isMove= ($lastDateArrivee == $tr['eng_date_depart'] || $tr['eng_date_depart'] == NULL);
                echo "<div class='cd-timeline-block'>
        	       <div class='cd-timeline-img cd-picture'>";
                if ($isMove) {
                    echo "<i class='fa fa-exchange'></i>";
                } else {
                    echo "<i class='fa fa-suitcase'></i>";
                }
        	   echo "</div> <!-- cd-timeline-img -->
                    <div class='cd-timeline-content'>";
                if ($isMove) {
                    $montant = number_format(round($tr['eng_montant'],1),1);
                    echo "<h2>Transfert</h2>
            	       <p>Acheté par {$tr['nomEkyp']} pour {$montant} Ka</p>
            	       <span class='cd-date'>{$tr['dateArrivee']}</span>";
                } else {
                    echo "<h2>Libéré</h2>
            	       <p>Libéré par {$tr['nomEkyp']}</p>
            	       <span class='cd-date'>{$tr['dateDepart']}</span>";
                }
            	echo "</div> <!-- cd-timeline-content -->
    	           </div> <!-- cd-timeline-block -->";
                $lastDateArrivee = $tr['eng_date_arrivee'];
            }
        }
        ?>
	</div>
	</div>
	<div id="playerInfo">
		<ul class="fa-ul">
			<li><i class="fa-li fa fa-home"></i>Sous contrat avec El Brutal Principe</li>
			<li><i class="fa-li fa fa-suitcase"></i>Sans contrat</li>
			<li><i class="fa-li fa fa-pencil-square-o"></i>Salaire contractuel : 12 Ka</li>
			<li><i class="fa-li fa fa-futbol-o"></i>Salaire virtuel : 8 Ka (-4) <span class='uppings' title='En hausse'><i class="fa fa-arrow-up"></i></span> <span class='downings' title='En baisse'><i class="fa fa-arrow-down"></i></span></li>
			<li class='highlight'><i class="fa-li fa fa-money"></i>En vente pour 5.5 Ka</li>
		</ul>
	</div>
	<div id="playerPerf">
	<h2>Historique des performances</h2>
	<table width="100%">
	<thead>
	<tr>
		<th>Journée</th><th>Rencontre</th><th>Franchise</th><th>Score</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>1</td><td>Reims 0 - 0 Nice</td><td>Libre</td><td>9.75</td>
	</tr>
	<tr>
		<td>2</td><td>Nice 1 - 2 Montpellier</td><td>Nation of Breizh</td><td>5.12</td>
	</tr>
	<tr>
		<td>3</td><td>Nice 3 - 1 Monaco</td><td>Nation of Breizh</td><td>11.4</td>
	</tr>
	</tbody>
	</table>
	</div>
</section>
