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
		<p>Sous contrat avec <a href="./index.php?kmpage=home&page=franchise">El Brutal Principe</a></p>
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
</section>
<!-- 
<script src="js/timeliner.min.js"></script>
<script src="js/custom/km-player.js"></script>
-->