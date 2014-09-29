<?php
	if (! isset($_GET['joueurid'])) {
		echo '<p class=\"error\">Pas de JoueurId !</p>';
		exit;
	}
	$joueurId = ($_GET['joueurid']);
	$getJoueurQuery = $db->getArray("select prenom,nom from joueur where id={$joueurId} limit 1");
?>

<section id="player">
	<div class='sectionInfo'>
	<h2><?php echo $getJoueurQuery[0]['prenom'].' '.$getJoueurQuery[0]['nom'] ?></h2>
		<p><span class="playerPosition" title="Défenseur">D</span> Lyon</p>
	</div>
	<div id="timeline">
	<div id="cd-timeline" class="cd-container">
		<!-- Présentation sous forme de timeline -->
		<div class="cd-timeline-block">
        	<div class="cd-timeline-img cd-picture">
        		<i class="fa fa-exchange"></i>
        	</div> <!-- cd-timeline-img -->
        	<div class="cd-timeline-content">
            	<h2>Transfert</h2>
            	<p>Acheté par El Brutal Principe pour 17.4 Ka</p>
            	<span class="cd-date">27/09/2014</span>
       		 </div> <!-- cd-timeline-content -->
    	</div> <!-- cd-timeline-block -->
    	<div class="cd-timeline-block">
        	<div class="cd-timeline-img cd-picture">
        		<i class="fa fa-suitcase"></i>
        	</div> <!-- cd-timeline-img -->
        	<div class="cd-timeline-content">
            	<h2>Libéré</h2>
            	<p>Libéré par Legion of Doom</p>
            	<span class="cd-date">15/09/2014</span>
       		 </div> <!-- cd-timeline-content -->
    	</div> <!-- cd-timeline-block -->
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
