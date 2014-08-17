<?php
include("includes/db.php");
include('process/checkAccess.php');
include ('vocabulaire.php');
include ('process/computeDate.php');
?>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Kamoulcup</title>
	<style type="text/css" media="all">
		@import "lodemars.css";
	</style>
	<script src="http://static.simile.mit.edu/timeline/api-2.3.0/timeline-api.js?bundle=true" type="text/javascript"></script>
	<script src="local_data.js" type="text/javascript"></script>
	<script type="text/javascript">
	var tl;
	function onLoad() {
		var eventSource = new Timeline.DefaultEventSource();
		var bandInfos = [
			Timeline.createBandInfo({
				width:          "70%", 
				intervalUnit:   Timeline.DateTime.WEEK, 
				intervalPixels: 100
			}),
			Timeline.createBandInfo({
				overview:       true,
				width:          "30%", 
				intervalUnit:   Timeline.DateTime.MONTH, 
				intervalPixels: 200
			})
		];
		bandInfos[1].syncWith = 0;
		bandInfos[1].highlight = true;
		tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
		var url = '.';
		//Timeline.loadXML("timelineEvents.xml", function(xml, url) { eventSource.loadXML(xml, url); });
		eventSource.loadJSON(timeline_data, url); // The data was stored into the 
                                                       // timeline_data variable.
         tl.layout(); // display the Timeline
 }

 var resizeTimerID = null;
 function onResize() {
     if (resizeTimerID == null) {
         resizeTimerID = window.setTimeout(function() {
             resizeTimerID = null;
             tl.layout();
         }, 500);
     }
 }
	</script>
</head>
<body onload="onLoad();" onresize="onResize();">
<div id="frisetop"></div>
<div id="header">
	<ul id="menu">
		<li><a href="http://www.kamouloxdufoot.com/kdf/viewtopic.php?t=3771&start=0" ><img src="images/forum.png" /></a></li>
		<li><a href="index.php?page=palmares" ><img src="images/palmares.png" /></a></li>
		<li><a href="regles.php" ><img src="images/regles.png" /></a></li>
		<?php 
		if (isset($_SESSION['myEkypId'])) {
			echo "<li><a href='index.php?page=myEkyp'><img src='images/myekyp.png' /></a></li>  ";
    	} 
		?>
	</ul>
  <a href='index.php?page=accueil'>
	<img src='images/blanc.gif' width=300 height=110 align='left' border=0></img>
  </a> 

</div> <!--fin header-->

<div id="containeur">
	<div id="coldroite">
				<?php
					if (isset($_SESSION['myEkypId'])) {
						$departageQuery = $db->getArray("select id from departage_vente where (ekyp_id='{$_SESSION['myEkypId']}') and ( montant_nouveau IS NULL ) and (date_expiration > now())");
						if ($departageQuery != NULL) {
							$nb = count($departageQuery);
							include('./div/ekypMessageDiv.php');
						}
					}
				?>
				<div class='classement'>
					<a href='index.php?page=ventesEnCours'><img src='./images/sallemarche.jpg' alt='Le marché'/></a>
				</div>
				
				<div class='hr_feinte'></div>
				<?php include('./div/classementEkypsDiv.php'); ?>
				<div class='hr_feinte'></div>
				<?php include('./div/rechercheDiv.php'); ?>
				<div class='hr_feinte'></div>
				<?php include('./div/classementJoueursDiv.php'); ?>
	</div> <!-- fin coldroite -->
	<div id="colgauche">
		<div class='titre_page'>Règles du jeu</div>
	
<div class='sous_titre'>I - Principe</div>
<p><b><u>But du jeu</b></u></p>
<p>Le but du jeu est de constituer la meilleure sélection de joueurs du championnat de France de Ligue en procédant à des recrutements lors des périodes d'ouverture du marché (les "merkatos"). Chaque joueur a un score en points qui reflète ses performances "sur le terrain" selon le barême détaillé plus bas. Chaque ékyp doit acheter les joueurs qui l'intéressent pour former sa sélection en remportant des enchères à enveloppe fermée.
<p>Le jeu se décompose en 2 phases : Apertura et Clausura. A l'issue de chaque phase, l'ékyp <b>complète</b> ayant accumulé le plus de points remporte ladite phase. Comme dans certains championnats de football sud-américains, il y peut y avoir deux différents champions par saison</p>

<p><b><u>Modalités</b></u></p>
<p>La première phase s'étale du 2 septembre 2010 au 22 décembre 2010 et comprend 3 périodes d'achat-vente (merkato) selon le calendrier suivant:</p>
<div id="my-timeline" style="height: 150px; border: 1px solid #aaa"></div>
<noscript>
This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.
</noscript>
<br/>
On peut participer par équipe ou tout seul, sous réserve de pouvoir se connecter 1 fois par 24 heures hors week-end.</p>
<br/>
<p><b>Il s'agit de recruter et construire la meilleure Sélection de 7 possible, en concurrence avec les autres participants.</b></p>
<br/>
<p>La Sélection peut être évidemment internationale et comprend 1 gardien, 2 défenseurs, 2 milieux, 2 attaquants.</p>
<br/>
<p>Le coup d'envoi du jeu est donné officiellement sur le forum. Ce sera vraisemblablement autour du 1er juin</p>
<p>Chaque participant/doublette peut alors commencer à recruter. Il dispose pour cela d'un budget de 100 Kamouls. Au début du jeu tous les joueurs sont libres et peuvent donc faire l'objet d'une Proposition d'Achat (PA).</p>
<br/>
<br/>
<p><b><u>1. Proposition d'Achat (PA)</b></u></p>
<p>Les PAs sont déposées publiquement par les joueurs dans la section du site appelée "Le safari". Dès que la PA est déposée une période d'enchère démarre pendant laquelle les participants vont se disputer ce joueur pour l'acquérir</p>
<p>Il n'y a pas de montant minimal pour une PA (à partir de 0,1 Kamoul).</p>
<p><b>Conditions pour pouvoir déposer une PA :</b></p>
<ul>
<li>Posséder au moins 0.1 Ka en banque</li>
<li>Ne pas avoir déjà une PA en cours</li>
<li>Ne pas avoir atteint le nombre maximum de joueurs autorisé dans les effectifs, remplaçant compris</li>
</ul>
<br/>
<p><b><u>2. Enchère (E)</b></u></p>
<p>
<b>L'" Enchère" n'est pas publique mais discrète sur le mode de la réponse sous enveloppe à un appel d'offre.</b>
<br/>
<p>A La fin de la période d'enchères, le joueur signe au plus offrant et l'argent transite.</p>
<p>Un participant ne doit jamais détenir plus de 9 joueurs au cours du jeu.</p>
<p>Le Kamoul n'admet comme division la plus basse que la première décimale. 2,4 Kamouls, OK. 2,42 Kamouls, pas OK.</p>

<p>Le montant des enchères est totalement libre et peut dépasser votre soldes de Kamouls. Mais si au moment de la résolution vous n'êtes pas en mesure d'honorer une enchère que vous avez postée, celle-ci ne sera pas prise en compte. </p>
<p><b>Conditions pour qu'une enchère postée soit considérée comme valide :</b></p>
<ul>
<li>Posséder suffisamment d'argent en banque pour être capable d'honorer à la fois le montant d'enchère proposé <b>et</b> le montant de mise en vente d'une éventuelle PA postée sur un autre joueur par le participant</li>
<li>Ne pas avoir atteint le nombre maximum de joueurs autorisé dans les effectifs, remplaçant compris <b>et</b> rester en mesure d'accueillir tout autre joueur sur lequel une PA du participant est en cours</li>
</ul>
<i>Exemple :</i> L'ékyp A possède déjà 8 joueurs. Elle poste une PA sur un autre joueur (son éventuel futur 9e donc) : PAA, et enchérit sur un joueur JA avant la résolution de PAA. L'enchère sur JA sera automatiquement déclarée invalide dans ce cas car si A remportait JA, elle ne serait plus en mesure d'honorer PAA ce qui est interdit.
<br/>
La validité d'une enchère est déterminée au moment précis de la résolution de la PA sur laquelle elle porte, ni avant, ni après.
<br/>
<p><b><u>3. Délai d'Enchère</b></u></p>
<p>Délai d'Enchère = 24 à 48 heures, à préciser</p>
<p>Les PA dont le délai expire durant le week end sont resolues le lundi suivant à 12h00, dans l'ordre de dépôt initial</p>
<p>Les PA déposées durant le week end sont resolues le mardi suivant à 23h59, dans l'ordre de dépôt initial</p>
<p>Pour chaque participant/doublette, une PA à la fois: nouvelle PA possible quand le joueur de sa PA précédente a été attribué.</p>
<br/>
<p><b>Ce rythme pourra être ajusté dans l'intérêt du jeu sans privilégier aucune ékyp.</b></p>
<br/>
<p><b><u>4. Remise en vente</b></u></p>
<p>Même principe que la PA. L'ékyp qui propose de revendre un joueur le présente dans la section "Safari" avec une mise à prix et un éventuel prix de réserve masqué. Un délai d'enchère s'ouvre. Une fois le délai d'enchère écoulé le joueur change de mains, vers le plus offrant, ou reste où il est si la mise à prix ou le prix de réserve n'a pas été atteinte.
<br/>
<p><b><u>5. Les Echanges et Transactions de gré à gré sont impossibles.</b></u></p>
<br/>
<p><b><u>6. Rachat par la Banque-Arbitre</b></u></p>
<p><b>Jusqu'à la fin des 2e match de poule (donc le 21 juin à 23h59)</b>, la Banque-Arbitre peut racheter les joueurs à <b>70% de leur prix d'achat</b> (un seul joueur par Sélection maxi).
L'argent transite immédiatement vers les caisses de l'ékyp.</p>
<p>Le joueur redevient libre et peut faire l'objet d'une nouvelle PA.</p>
<p>Un joueur qui se blesse avant le 11 Juin et ne peut disputer le Mondial est racheté par la Banque à <b>85% de son prix d'achat</b>.</p>
<br/>
<p><b><u>7. Résolution des enchères</b></u></p>
<p>Les enchères dont le délai est écoulé sont résolues automatiquement. Le déclenchement de la résolution à lieu à 13h puis à 20h chaque jour.
<p>Le moteur du jeu se met alors en branle pour attribuer les joueurs aux plus offrant en respectant les critères de validité des offres décrits plus haut.</p>
<p>Le site indique finalement le résultat de cet arbitrage, et les transferts (de joueurs comme de fonds) sont réalisés immédiatement</p>
<br/>
<p>Dans le cas où la meilleure offre pour un joueur serait partagée par plusieurs ékyps, ces ékyps sont dites "en ballotage". Il leur est proposé de surenchérir pour se départager. Dans ce cas une notification est visible en tête de la colonne de droite lorsque les ékyps concernées se connectent</p>
<p>Les ékyps concernées peuvent si elle souhaite formuler une nouvelle offre supérieure pour ce joueur. Attention : il y a un délai (égal au délai d'enchères écoulé) pour répondre.</p>
<p>Lorsque toutes les ékyps concernées ont surenchéri ou que le délai est écoulé, le joueur est attribué au plus offrant. <b>Si deux ékyps ou plus sont à nouveau à égalité, le gagnant est alors tiré au sort.</b></p>
<p>En résumé:</p>
<img src="images/resolution.png"/>
<br/>
<p><b><u>8. FAQ-Explications</b></u></p>
<p><i>-Un participant peut-il annuler sa PA ?</i></p>
<p>Non, la PA a pour conséquence de mettre un joueur sur le marché et qu'il soit décidé à quelle sélection il sera attribué et à quel prix. Idem pour la Revente.</p>
<br/>
<p><i>-Peut-on enchérir sur sa propre PA?</i></p>
<p>Oui, et on y a même intérêt si on pense que le montant de sa PA ne suffira pas à acquérir le joueur.</p>
<br/>
<p><i>-Pour faire une PA doit-on avoir nécessairement l'argent disponible?</i></p>
<p>Oui. Il est interdit de faire une PA qu'on ne pourrait honorer financièrement.</p>
<br/>
<p><i>-Peut-on faire plusieurs Enchères au delà de l'argent disponible?</i></p>
<p>Oui, mais si on gagne plusieurs enchères au-delà de ses moyens, le joueur qui signe est celui dont la PA est la plus ancienne. Une équipe ne peut pas être en déficit.</p>
<p>Par ailleurs, comme on a vu qu'il faut toujours être en mesure d' honorer sa propre PA: une enchère gagnante ayant eu pour conséquence de rendre insolvable un participant pour sa propre PA , sera rétroactivement analysée comme nulle.</p>
<br/>
<p><i>-Peut-on annuler une Enchère?</i></p>
<p>Oui, mais nécessairement avant l'expiration du délai d'enchère.</p>
<p>Une fois un joueur obtenu on ne peut pas y renoncer.</p>
<br/>
<p><i>-Pourquoi les échanges et transactions de gré à gré sont-ils impossibles?</i></p>
<p>D'abord ces opérations nécessitent des connections simultanées et favoriseraient les plus connectés, or la règle est conçue pour être jouable avec une connexion par jour.
Accessoirement ces transactions pourraient nuire à la concurrence loyale (libre et non faussée-), que garantit la procédure d'appel d'offre: PA publique accessible à tous les participants puis Enchères "sous enveloppe".</p>
<br/>
<p><i>-Et si on n'a plus d'argent?</i></p>
<p>Fallait y penser avant -)</p>
<p>A chacun de voir s'il veut anticiper ou au contraire être en mesure d'acheter des joueurs même en fin de compétition. En tout cas tout le monde est sur un pied d'égalité.</p>
<br/>
<p><i>-Les participants peuvent-ils communiquer entre eux?</i></p>
<p>Oui parce que vérifier le contraire serait de toutes façons impossible. Les participants peuvent donc s'informer ou s'intoxiquer.</p>
<br/><br/>

<div class='sous_titre'>II - Mode d'évaluation des Sélections</div>
<p>Chaque joueur sera crédité d'un score composé en deux parties:</p>
<br/>
<p><b><u>1.3 fois la note moyenne de la presse.</u></b></p>
<p>Les médias retenus seront A DETERMINER</p>
<p></p>
<br/>
<p>A la fin de la Coupe du monde, chaque joueur aura donc une note moyenne sur 10 (ex 6/10).</p>
<br/>
<p>Pour les joueurs ayant été notés dans trois matches et plus, cette note moyenne sera créditée trois fois (total 18 dans l'exemple)</p>
<p>Pour les joueurs ayant été notés dans deux matches seulement, il sera crédité "deux fois la note moyenne plus 4" ( 16 dans l'exemple)</p>
<p>Pour les joueurs n'ayant été notés que dans un match il sera crédité "une fois la note plus 7" (13 dans l'exemple).</p>
<p>Un joueur sans aucune note du fait d'un temps de jeu insuffisant, mais ayant participé, sera crédité d'1 point par entrée, plus 3 points par entrée de plus de 10 minutes, le tout plafonné à 12.</p>
</p>
<br/>
<p><b><u>2. Bonus</u></b></p>
<table class='tableau_saisie'>
<tr><th colspan='3'>Pas de but encaissé</th></tr>
<tr><th>Position du joueur</th><th>Bonus en poule + 3e place</th><th>Bonus en match éliminatoire</th></tr>
<tr><td>gardien</td><td align='right'>1</td><td align='right'>2</td></tr>
<tr><td>défenseur</td><td align='right'>0.75</td><td align='right'>1.5</td></tr>
<tr><td>milieu</td><td align='right'>0.25</td><td align='right'>0.5</td></tr>
</table>
<p>1 seul but encaissé et celui-ci l'a été sur pénalty et/ou durant les prolongations: la moitié des bonus accordés ci-dessus</p>
<br/>
<table class='tableau_saisie'>
<tr><th colspan='3'>Autres bonus</th></tr>
<tr><th>Performance</th><th>Bonus en poule + 3e place</th><th>Bonus en match éliminatoire</th></tr>
<tr><td>Par but marqué</td><td align='right'>0.75</td><td align='right'>1.5</td></tr>
<tr><td>Par pénalty marqué</td><td align='right'>0.375</td><td align='right'>0.75</td></tr>
<tr><td>Par passe décisive</td><td align='right'>0.5</td><td align='right'>1</td></tr>
<tr><td>Par pénaly obtenu</td><td align='right'>0.25</td><td align='right'>0.5</td></tr>
<tr><td>joueur  retenu dans la présélection Fifa All Star short list</td><td align='right' colspan='2'>+1</td></tr>
<tr><td>joueur retenu dans la Fifa All Star Team définitive</td><td align='right' colspan='2'>+1</td></tr>
</table>
<br/>
<p>Exemple d'un défenseur ayant disputé 2 matches de poule (dont 1 sans but encaissé) et deux matches à élimination directe (2-1,1-2, un but marqué), note moyenne de 7/10 sur les 4 matches, pré-sélectionné all star</p>
<p>Score=</p>
<p>3 X 7 (3 fois la note moyenne)</p>
<p>+0,5 (match de poule sans but encaissé)</p>
<p>+1,5 (1 but marqué en match élimination directe)</p>
<p>+1 (présélectionné all star)</p>
<p><b>= 24 points</b></p>
<br/>
<p>une Sélection cumule l'ensemble des points des 7 joueurs titulaires qui la composent quelle que soit leur date d'acquisition.</p>
<br/>
<br/>
<p>Gagne la KamoulCup la Sélection de 7 ayant remporté le plus de points.</p>
<p>Une Sélection incomplète ne peut être classée.</p>
<br/>
<p>FIN du règlement.</p>				
	</div> <!-- fin colgauche -->
	<hr/>
</div> <!--fin containeur-->

<div id="footer">
	<?php
	if (isset($_SESSION['userrights'])) {
		echo "<ul id='menufooter'>";
		echo "<li><a href='process/disconnect.php' ><img src='images/deconnexion.png' /></a></li>";
		echo "<li><a href='index.php?page=baboon' ><img src='images/baboon.png'/></a></li>";
		echo "</ul>";
	} else {
			echo "<ul id='menufooter'><li><a href='index.php?page=identification'><img src='images/connexion.png' /></a></li></ul> ";
		}
	?>
</div> <!--fin footer-->
<div id="frisebottom">
<div id="credits">Programmation: Charlie Brown - Graphismes: Lo de Mars - Idée originale: Peterelephanto</div>
</div> <!-- frise bottom -->

</body>
</html>
