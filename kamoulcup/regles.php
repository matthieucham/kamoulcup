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
				eventSource: 	eventSource,
				date:			"Sep 01 2013 00:00:00 GMT",
				width:          "70%", 
				intervalUnit:   Timeline.DateTime.WEEK, 
				intervalPixels: 100
			}),
			Timeline.createBandInfo({
				overview:       true,
				eventSource: 	eventSource,
				date:			"Oct 01 2013 00:00:00 GMT",
				width:          "30%", 
				intervalUnit:   Timeline.DateTime.MONTH, 
				intervalPixels: 200
			})
		];
		bandInfos[1].syncWith = 0;
		bandInfos[1].highlight = true;
		tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
		var url = '.';
		Timeline.loadXML("timelineEvents.xml", function(xml, url) { eventSource.loadXML(xml, url); });
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
		<li><a href="http://www.kamouloxdufoot.com/kdf/viewtopic.php?t=4295&start=0" ><img src="images/forum.png" /></a></li>
		<li><a href="http://www.kamoulcup.com/l1/archives/" ><img src="images/palmares.png" /></a></li>
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

<div class="sous_titre">I - Principe</div>
<p><b><u>But du jeu</u></b></p>
<p>Le but du jeu est de constituer la meilleure sélection de joueurs du championnat de France de Ligue en procédant à des recrutements lors des périodes d'ouverture du marché (les "merkatos"). Chaque joueur a un score en points qui reflète ses performances "sur le terrain" selon le barême détaillé plus bas. Chaque ékyp doit acheter les joueurs qui l'intéressent pour former sa sélection en remportant des enchères à enveloppe fermée.
</p><p>Le jeu se décompose en 2 phases : Apertura et Clausura. A l'issue de chaque phase, l'ékyp <b>complète</b> ayant accumulé le plus de points remporte ladite phase. Comme dans certains championnats de football sud-américains, il y peut y avoir deux différents champions par saison. . L’ékyp ayant accumulé le plus de points sur la saison entière remporte la Kamoulcup de la saison. Il est donc en théorie possible qu’une ékyp donnée remporte l’Apertura, une autre la Clausura, et une troisième le classement général.</p>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">Périodes couvertes par chaque classement</th></tr>
<tr><td>Apertura</td><td>Score des joueurs basé sur leurs performances de la 1ère à la 19e journée de L1</td></tr>
<tr><td>Clausura</td><td>Score des joueurs basé sur leurs performances de la 20e à la 38e journée de L1</td></tr>
<tr><td>Saison complète</td><td>Score des joueurs basé sur leurs performances de la 1ère à la 38e journée de L1</td></tr>
</tbody></table>
<p>Le vainqueur de l'Apertura est proclamé à l'issue de la 19e journée de L1. Pour la Clausura et la Saison complète, il faut bien sûr attendre la 38e journée</p>
<br/>
<p><b><u>Modalités</u></b></p>
<p><u>Calendrier</u></p>
Chaque année, la compétition est rythmée par les jalons suivants.<br/>
<ul>
	<li><i>J0</i> : Attribution à chaque ékyp d'un joueur qu'elle a pu choisir par ordre de préférence en fonction de son classement lors de l'édition précédente (Voir plus loin "Draft")</li>
	<li><i>J1</i> : Début du merkato bonifié de l'Apertura</li>
	<li><i>J2</i> : Fin des bonifications*</li>
	<li><i>J3</i> : Fin du merkato de l'Apertura</li>
	<li><i>J4</i> : Chaque ékyp choisit parmi ses joueurs ceux qu'elle désire conserver pour la Clausura, ainsi qu'un schéma tactique pour la suite de la compétition</li>
	<li><i>J5</i> : Début du merkato de la Clausura</li>
	<li><i>J6</i> : Fin du merkato de la Clausura</li>
</ul>
<p>* Voir plus bas le chapitre "Evaluation des joueurs"</p>
<p>Les dates exactes de ces jalons sont ajustées au début de chaque saison en fonction du calendrier du championnat de France de Ligue 1. En général, J0 fait suite à la fermeture du marché des transferts estival de L1, J1 suit immédiatement J0, J2 arrive 2 semaines après J1, J3 intervient 3 semaines après J2. De mème, J4 est placé juste après la clôture du marché des transferts hivernal de L1, J5 suit immédiatement J4 et J6 se place 5 semaines après J5.</p>
<p>Divers points de contrôle sont posés au cours du jeu afin de maintenir les ékyps impliquées de bout en bout:</p>
<ul>
	<li><i>PC1</i> : Toute ékyp n'ayant pas déposé au minimum 3 PAs à cette date sera dissoute et confiée à un éventuel repreneur. Si personne ne souhaite reprendre l'ékyp, tous les joueurs sont libérés et remis immédiatement sur le marché</li>
	<li><i>PC2</i> : Toute ékyp n'ayant pas déposé au minimum 6 PAs à cette date sera dissoute et confiée à un éventuel repreneur. Si personne ne souhaite reprendre l'ékyp, tous les joueurs sont libérés et remis immédiatement sur le marché</li>
	<li><i>PC3</i> : Toute ékyp n'ayant pas déposé au minimum 8 PAs à cette date sera dissoute. Ses joueurs seront remis sur le marché au début du merkato de la Clausura, ils seront donc indisponibles jusqu'à la fin de l'Apertura</li>
	<li><i>PC4</i> : Toute ékyp ékyp doit possèder <b>au moins 7 joueurs dont au moins 1 gardien, au moins 3 défenseurs, au moins 2 milieux et au moins un attaquant</b>. Toute ékyp incomplète sera éliminée. Ses joueurs seront remis sur le marché au début du merkato de la Clausura, ils sont donc indisponibles jusqu'à la fin de l'Apertura</li>
	<li><i>PC5</i> : Toute ékyp n'ayant pas déposé au minimum 2 PAs à cette date lors de la Clausura sera éliminée immédiatement. Ses joueurs ne seront pas remis sur le marché : ils seront indisponibles jusqu'à la fin du jeu</li>
	<li><i>PC6</i> : Toute ékyp n'ayant pas déposé au minimum 4 PAs à cette date lors de la Clausura sera éliminée immédiatement. Ses joueurs ne seront pas remis sur le marché : ils seront indisponibles jusqu'à la fin du jeu</li>
</ul>
<p>Faites défiler la ligne temporelle ci-dessous pour consulter les dates exactes de l'édition en cours.
Les points comme les lignes sont cliquables.</p>
<div id="my-timeline" style="height: 150px; border: 1px solid #aaa"></div>
<noscript>
This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.
</noscript>
<p><u>Draft</u></p>
<p>Avant le début du merkato a lieu une draft visant à attribuer à chaque ékyp un joueur, et un seul, gratuitement, hors merkato. Le classement présidant à la draft est établi en fonction du classement général de la saison précédente, où l'on retranche du score final de chaque ékyp le score obtenu par son drafté. Pour les ékyps s'étant séparés de leur drafté en cours de saison, c'est le total obtenu par leur meilleur joueur qui est retranché. L’ékyp ayant terminé à la première place obtenant le premier choix de draft, la deuxième obtenant le deuxième choix et ainsi de suite. En cas de dissolution d’une ékyp, son ordre de draft est attribué à l’ékyp la suivant au classement. Les ékyps nouvellement créées se voient attribuer un ordre de draft en fonction de la date de leur inscription. Elles bénéficieront de leur ordre de draft après les ékyps déjà présentes les saisons précédentes.</p>
<p>Chaque ékyp remplit sur le site le formulaire idoine visant à déterminer son choix de draft. L’ékyp disposant du premier choix n’envoie qu’un seul nom ; l’ékyp disposant du deuxième choix en envoie deux, en précisant l’ordre de préférence, et ainsi de suite. Chaque ékyp se verra attribuer le premier joueur du classement de préférence qu’elle a établi à ne pas avoir été attribué à une ékyp au choix de draft supérieur.</p>
<p><u>Exemple :</u> L’ékyp A, disposant du choix de draft 1, choisit Dupont.
<br/>
L’ékyp B, disposant du choix de draft 2, choisit 1) Dupont 2) Durand.
<br/>
L’ékyp C, disposant du choix de draft 3, choisit 1) Durand 2) Dugenou 3) Duval
<br/>
Dans ce cas de figure, L’ékyp A obtient Dupont, l’ékyp B obtient Durand, l’ékyp C obtient Dugenou.
</p>
<p>Une fois dans l’effectif d’une ékyp, le joueur drafté est traité à l’instar de n’importe quel autre joueur : il peut être mis sur le marché dans le cadre d’une Mise en Vente (MV), <b>mais ne peut pas être racheté par la Banque Arbitre (BA)</b>. Par ailleurs, son score ne bénéficiera pas de l’augmentation de 5% dont bénéficieront les scores des joueurs achetés lors de la phase bonifiée du merkato.



<p><u>Première phase (Apertura)</u></p>
On peut participer par équipe ou tout seul, sous réserve de pouvoir se connecter 1 fois par 48 heures hors week-end durant les deux premiers merkatos.<p></p>
<br/>
<p><b>Pour la première phase, il s'agit de recruter et construire la meilleure Sélection de 7 possible, en concurrence avec les autres participants.</b></p>
<br/>
<p>La Sélection comprend <b>1 gardien, 3 défenseurs, 2 milieux, 1 attaquant.</b></p>
<br/>
<p>Pour former sa sélection, chaque ékyp dispose d'un budget de 100 Kamouls. Au début du jeu tous les joueurs sont libres et peuvent donc faire l'objet d'une Proposition d'Achat (PA). Un joueur ne peut appartenir qu’à une seule ékyp à la fois.</p>
<p>A aucun moment au cours de la première phase une ékyp ne doit posséder plus de <b>9</b> joueurs</p>
<br/>
<p><u>Transition vers la deuxième phase</u></p>
<p>A l'issue de la première phase, chaque ékyp doit indiquer par MP au Super Baboon quels sont les 5 joueurs de son effectif qu'elle souhaite conserver pour la deuxième phase. Dans cette sélection, chaque ékyp est libre de choisir les 5 joueurs qu'elle veut conserver (y compris parmi les remplaçants), sans la moindre restriction concernant les postes desdits joueurs.</p>
<p>En l'absence de MP, le Supreme Baboon conserve les 5 joueurs au score le plus élevé, quel que soit leur poste.</p>
<p>En même temps que le choix de ses 5 joueurs conservés, chaque ékyp communique au Supreme Baboon la tactique souhaitée pour la Clausura parmi: 
<ul>
<li>4/4/2 (2 attaquants)</li>
<li>4/3/3 (3 attaquants)</li>
<li>5/3/2 (5 défenseurs)</li> 
<li>3/5/2 (5 milieux)</li>
</ul>
</p>
<p>Les joueurs non conservés sont libérés et remis sur le marché pour la deuxième phase.</p>
<p>Les joueurs conservés ne peuvent pas être revendus à la banque au cours de la deuxième phase</p>
<br/>
<p><u>Deuxième phase (Clausura)</u></p>
<br/>
<p><b>Pour la deuxième phase, il s'agit de compléter sa sélection de 5 en recrutant au moins 6 nouveaux joueurs pour construire la meilleure Sélection de 11 possible, conformément à l’organisation tactique décidée par chaque ékyp lors de la transition entre la première et la deuxième phase.</b></p>
<br/>
<p>Pour compléter sa sélection, chaque ékyp dispose à nouveau d'un budget de 100 Kamouls.</p>
<p>A aucun moment au cours de la seconde phase une ékyp ne doit posséder plus de <b>14</b> joueurs</p>
<br/>
<br/>
<p><b><u>1. Proposition d'Achat (PA)</u></b></p>
<p>Les PAs sont déposées publiquement par les joueurs dans la section du site appelée "Le marché de la petite merde gâtée". Dès que la PA est déposée une période d'enchère démarre pendant laquelle les participants vont se disputer ce joueur pour l'acquérir</p>
<p>Il n'y a pas de montant minimal pour une PA (à partir de 0,1 Kamoul).</p>
<p>Une PA peut être déposée sur n’importe quel joueur évoluant en Ligue 1 ou y ayant déjà disputé au moins un match dans le courant de la saison. Ainsi, un joueur qui aurait disputé la totalité de la première partie de la saison avant d’être transféré hors L1 lors du mercato d’hiver peut être mis en PA. Les joueurs se retrouvant dans ce cas de figure seront classés dans le club « sans club » et accessibles lors des postages de PA.</p>
<p><b>Conditions pour pouvoir déposer une PA :</b></p>
<ul>
<li>Posséder au moins 0.1 Ka en banque</li>
<li>Ne pas avoir déjà une PA en cours</li>
<li>Ne pas avoir atteint le nombre maximum de joueurs autorisé dans les effectifs, remplaçant compris</li>
</ul>
<br/>
<p><b><u>2. Enchère (E)</u></b></p>
<p>
<b>L'" Enchère" n'est pas publique mais discrète sur le mode de la réponse sous enveloppe à un appel d'offre.</b>
<br/>
</p><p>A La fin de la période d'enchères, le joueur signe au plus offrant et l'argent transite.</p>
<p>Le Kamoul n'admet comme division la plus basse que la première décimale. 2,4 Kamouls, OK. 2,42 Kamouls, pas OK.</p>

<p>Le montant des enchères est totalement libre et peut dépasser votre soldes de Kamouls. Mais si au moment de la résolution vous n'êtes pas en mesure d'honorer une enchère que vous avez postée, celle-ci ne sera pas prise en compte. </p>
<p><b>Conditions pour qu'une enchère postée soit considérée comme valide :</b></p>
<ul>
<li>Posséder suffisamment d'argent en banque pour être capable d'honorer à la fois le montant d'enchère proposé <b>et</b> le montant de mise en vente d'une éventuelle PA postée sur un autre joueur par le participant</li>
<li>Ne pas avoir atteint le nombre maximum de joueurs autorisé dans les effectifs, remplaçant compris <b>et</b> rester en mesure d'accueillir tout autre joueur sur lequel une PA du participant est en cours</li>
</ul>
<p><i>Exemple 1:</i> L'ékyp A possède déjà 8 joueurs. Elle poste une PA sur un autre joueur (son éventuel futur 9e donc) : PAA, et enchérit sur un joueur JA avant la résolution de PAA. L'enchère sur JA sera automatiquement déclarée invalide dans ce cas car si A remportait JA, elle ne serait plus en mesure d'honorer PAA ce qui est interdit.</p>
<p><i>Exemple 2:</i> L’ékyp A possède 4 joueurs et 15 Ka. Elle met l’un de ses joueurs (Durand) en vente. Après la mise en vente de Durand, mais avant la résolution de cette mise en vente, l’ékyp A (ou une autre ékyp) met en PA un autre joueur, Dupont. L’ékyp A met 18 Ka sur Dupont. Cette somme est supérieure aux 15Ka qu’elle possède, mais elle espère retirer assez de Ka de la vente de Durand pour pouvoir acheter Dupont. Durand est vendu pour 5 Ka. L’ékyp A possède donc désormais 20 Ka. Quand vient la résolution portant sur Dupont, les 18 Ka de l’ékyp A sont pris en compte normalement. S’il s’agit de l’enchère la plus élevée, Dupont est attribué à l’ékyp A. Si en revanche Durand n’est vendu que 2,5 Ka, l’ékyp A se retrouve alors avec seulement 17,5 Ka et ne peut pas honorer son enchère de 18 Ka sur Dupont. Cette enchère est alors invalidée — et cela même si la deuxième enchère sur Dupont est inférieure à la somme de 17,5 Ka que l’ékyp A a dans son portefeuille au moment où cette PA est résolue.</p>
<br/>
La validité d'une enchère est déterminée au moment précis de la résolution de la PA sur laquelle elle porte, ni avant, ni après.
<br/>
<p><b><u>3. Délai d'Enchère</u></b></p>
<p>Le délai d'Enchère  (période suivant la déclaration d'une PA pendant laquelle il est possible de poster des enchères) est <b>au minimum de 48 heures</b> afin de permettre à tous de jouer à chances égales en se connectant une fois tous les deux jours pendant les périodes de merkato.</p>
<p>La date de fin du délai est ajustée afin que le délai expire à 12h ou 19h au moins 48h après l'heure d'envoi de la PA.</p>
<p>Les heures de week end ne sont pas comptabilisée dans le délai : le week end, c'est relâche.</p>
<p>Chaque ékyp ne peut avoir qu'une seule PA en cours à la fois: il faut attendre que le joueur mis en vente par sa PA précédente ait été attribué avant de pouvoir poster une PA à nouveau. Ceci est valable également lorsque la résolution d'une PA est retardée en raison d'un ballotage.</p>
<br/>
<p><b>Ce rythme pourra être ajusté dans l'intérêt du jeu sans privilégier aucune ékyp.</b></p>
<br/>
<p><b><u>4. Remise en vente (MV)</u></b></p>
<p>Selon le même principe que les PA : Une ékyp peut proposer de revendre un joueur avec une mise à prix visible de tous et un éventuel prix de réserve masqué. Un délai d'enchère s'ouvre alors. Une fois le délai d'enchère écoulé le joueur change de mains, vers le plus offrant, ou reste où il est si la mise à prix ou le prix de réserve n'a pas été atteinte.</p>
<p>Chaque ékyp ne peut avoir qu'un seul joueur en vente à la fois. En revanche il est possible d'avoir une PA et une MV en cours.</p>
<p>La Banque Arbitre prélève auprès du vendeur 10% de la somme que lui rapporte la revente d’un joueur à une autre ékyp. Ainsi, si l’ékyp A met en vente Durand et que l’ékyp B achète Durand pour 20 ka, alors l’ékyp A recevra 18 Ka tandis que l’ékyp B aura dépensé 20 Ka.</p>
<br/>
<p><b><u>5. Les Echanges et Transactions de gré à gré sont impossibles.</u></b></p>
<br/>
<p><b><u>6. Rachat par la Banque-Arbitre</u></b></p>
<p><b>Pendant les période d'ouverture des merkatos</b>, la Banque-Arbitre peut racheter les joueurs à <b>50% de leur prix d'achat</b> (deux joueurs par ékyp et par phase au maximum).
La transaction est immédiatement enregistrée et la banque garantit que l’argent issu de la revente sera disponible dès la prochaine séquence de résolutions. Toutefois, l’opération de rachat par la banque reste invisible des autres participants et ne sera révélée qu’à l’heure de résolutions des autres types de transaction, c'est-à-dire 12h ou 19h.</p>
<p>Une fois le rachat rendu public, le joueur concerné redevient libre et peut faire l'objet d'une nouvelle PA.</p>
<br/>
<p><b><u>7. Résolution des enchères</u></b></p>
<p>Les enchères dont le délai est écoulé sont résolues automatiquement. Le déclenchement de la résolution à lieu à 12h05 puis à 19h05 chaque jour.
</p><p>Le moteur du jeu se met alors en branle pour attribuer les joueurs aux plus offrant en respectant les critères de validité des offres décrits plus haut.</p>
<p>Le site indique finalement le résultat de cet arbitrage, et les transferts (de joueurs comme de fonds) sont réalisés immédiatement</p>
<br/>
<p>Lorsque les résolutions des ventes de plusieurs joueurs se produisent lors de la même session, ces résolutions se produisent <b>DANS L’ORDRE CHRONOLOGIQUE DE POSTAGE DES PA ET DES MV</b>. Si par exemple le 20 septembre à 12h05 viennent à échéance 1) la PA sur Dupont 2) la MV sur Durand, l’ékyp ayant vendu Durand reçoit son argent APRES la résolution de la PA sur Dupont : elle ne peut donc pas utiliser tout ou partie des Ka obtenus de la vente de Durand pour acheter Dupont.</p>
<br/>
<p>Dans le cas où la meilleure offre pour un joueur serait partagée par plusieurs ékyps, ces ékyps sont dites "en ballotage". Il est alors immédiatement procédé à un tirage au sort, et le joueur est attribué au vainqueur de ce tirage au sort, au prix du ballottage.</p>
<br/>
<p><b><u>8. FAQ-Explications</u></b></p>
<p><i>-Un participant peut-il annuler sa PA ?</i></p>
<p>Non, la PA a pour conséquence de mettre un joueur sur le marché et qu'il soit décidé à quelle sélection il sera attribué et à quel prix. Idem pour la Mise en vente.</p>
<br/>
<p><i>-Peut-on enchérir sur sa propre PA?</i></p>
<p>Oui, et on y a même intérêt si on pense que le montant de sa PA ne suffira pas à acquérir le joueur.</p>
<br/>
<p><i>-Pour faire une PA doit-on avoir nécessairement l'argent disponible?</i></p>
<p>Oui. Il est interdit de faire une PA qu'on ne pourrait honorer financièrement.</p>
<p>Les règles ont pour but de faire en sorte qu'absolument toutes les PA postées se soldent par un transfert, vers l'auteur de la PA le cas échéant lorsqu'aucune offre solvable n'a été reçue.<b>Il faut donc que l'auteur de la PA pense à toujours conserver en banque au moins le montant de sa PA en cours lorsqu'il enchérit sur d'autres joueurs, afin que ces enchères ne soient pas rejetées</b></p>
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
<br/>
<p><i>-Et si on n'a plus d'argent?</i></p>
<p>Fallait y penser avant -)</p>
<p>A chacun de voir s'il veut anticiper ou au contraire être en mesure d'acheter des joueurs même en fin de compétition. En tout cas tout le monde est sur un pied d'égalité.</p>
<br/>
<p><i>-Les participants peuvent-ils communiquer entre eux?</i></p>
<p>Oui parce que vérifier le contraire serait de toutes façons impossible. Les participants peuvent donc s'informer ou s'intoxiquer.</p>
<br/><br/>

<div class="sous_titre">II - Mode d'évaluation des Sélections</div>
<p>Chaque joueur sera crédité d'un score composé en deux parties:</p>
<br/>
<p><b><u>1.Les 13 meilleures notes attribuées par la presse. (26 pour la seconde phase)</u></b></p>
<p></p>
<br/>
<p>Un joueur expulsé au cours d'un match n'aura aucune note pour ce match</p>
<br/>
<p>Les joueurs n'ayant pas reçu au moins 13 notes (26 en seconde phase) obtiendront les compensations suivantes:</p>
<p>3 points par participation au match non notée de plus de 15 minutes (inclus).</p>
<p>1 point par participation au match de strictement moins de 15 minutes</p>
<p>Le nombre d'entrées en jeu considérées (3 points et 1 points confondues) ne peut pas excéder le nombre de notes manquantes pour atteindre les 13 ou 26 nécessaires. Les entrées "à 3 points" sont prises en compte en priorité sur les entrées à 1 point pour atteindre la limite.</p>
<p>Le temps de jeu enregistré ne tient pas compte des arrêts de jeu : On considère toujours qu'un match dure 90 minutes. Ainsi, un remplaçant qui entre en jeu à la 80e minute n'obtiendra qu'un point, même s'il y a plus de 5 minutes d'arrêts de jeu.</p>
<br/>
<p><b><u>2. Bonus collectifs</u></b></p>
<p>Les bonus collectifs ne sont accordés qu'aux joueurs ayant passé au moins 45 minutes sur le terrain.</p>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">Pas de but encaissé</th></tr>
<tr><th>Position du joueur</th><th>Bonus</th></tr>
<tr><td>gardien</td><td align="right">3.4</td></tr>
<tr><td>défenseur</td><td align="right">2.5</td></tr>
<tr><td>milieu</td><td align="right">1</td></tr>
</tbody></table>
<br/>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">1 seul but encaissé et celui-ci l'a été sur pénalty</th></tr>
<tr><th>Position du joueur</th><th>Bonus</th></tr>
<tr><td>gardien</td><td align="right">1.7</td></tr>
<tr><td>défenseur</td><td align="right">1.25</td></tr>
<tr><td>milieu</td><td align="right">0.5</td></tr>
</tbody></table>
<br/>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">Exactement trois buts marqués (tous dans le jeu) ou au moins 4 buts marqués  </th></tr>
<tr><th>Position du joueur</th><th>Bonus</th></tr>
<tr><td>milieu</td><td align="right">0.4</td></tr>
<tr><td>attaquant</td><td align="right">1</td></tr>
</tbody></table>
<br/>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">Exactement 3 buts marqué dont un et un seul sur pénalty </th></tr>
<tr><th>Position du joueur</th><th>Bonus</th></tr>
<tr><td>milieu</td><td align="right">0.2</td></tr>
<tr><td>attaquant</td><td align="right">0.5</td></tr>
</tbody></table>
<br/>
<p><b><u>3. Bonus individuels</u></b></p>
<p>Ils sont attribués à chaque match à tous les joueurs concernés sans limite de temps de jeu</p>
<br/>
<table class="tableau_saisie">
<tbody><tr><th colspan="2">Meilleure note moyenne de la presse</th></tr>
<tr><th>Position du joueur</th><th>Bonus</th></tr>
<tr><td>défenseur</td><td align="right">1.2</td></tr>
<tr><td>milieu</td><td align="right">0.6</td></tr>
</tbody></table>
<i>Le bonus est attribué sans division à tous les joueurs les mieux notés s'il y a égalité</i>
<br/>
<br/>
<br/>

<table class="tableau_saisie">
<tbody><tr><th colspan="2">Bonus spécial gardiens</th></tr>
<tr><th>Performance</th><th>Bonus</th></tr>
<tr><td>Plus de 3 arrêts dans le même match</td><td align="right">0.9</td></tr>
</tbody></table>
<i>Ce bonus ne concerne que les joueurs ayant été enregistrés avec le poste "Gardien". Un joueur de champ que les circonstances amènent à occuper le poste de gardien n'aura pas ce bonus lié à ce poste.</i>
<br/>
<br/>
<br/>

<table class="tableau_saisie">
<tbody><tr><th colspan="2">Autres bonus</th></tr>
<tr><th>Performance</th><th>Bonus</th></tr>
<tr><td>Par but marqué</td><td align="right">3</td></tr>
<tr><td>Par pénalty marqué</td><td align="right">1.5</td></tr>
<tr><td>Par passe décisive</td><td align="right">2</td></tr>
<tr><td>Par pénaly obtenu</td><td align="right">1</td></tr>
<tr><td>Par pénaly arrêté ou détourné</td><td align="right">3</td></tr>
<tr><td>Nommé dans l'équipe type de la saison (Trophée UNFP)</td><td align="right" colspan="2">1.5</td></tr>
<tr><td>Désigné meilleur joueur, meilleur gardien ou meilleur espoir (Trophée UNFP)	</td><td align="right" colspan="2">3</td></tr>
</tbody></table>
<p>Si un joueur est désigné à la fois meilleur joueur et meilleur goal ou meilleur espoir, il obtient 6 points : les bonus se cumulent</p>
<br/>
<p><b><u>Bonification du score</u></b></p>
<p>Les joueurs tranférés à l'issue d'une PA déposée durant la période du Merkato Bonifié verront leur score total majoré de 5% pour toute la durée de la saison ou jusqu'à leur transfert dans une autre ékyp.</p>
<p>Un joueur acheté pendant la période du Merkato bonifié puis revendu à la Banque Arbitre ne bénéficiera plus du bonus de 5% s’il est par la suite remis sur le marché.</p>
<br/>
<p><b><u>Sources de données pour la détermination des scores</u></b></p>
<p>Les journaux en ligne dont les notes seront reprises pour calculer les scores des joueurs sont susceptibles de varier au cours de la saison, en fonction de la disponibilité des dites sources.</p>
<p>Pour l'édition en cours, les notes sont issues des sites Whoscored.com et Sports.fr, sans redressement.</p>
<p>Les positions des joueurs seront fixées selon les classifications trouvées sur les sites officiels des clubs, ou sur celle de L'Equipe en l'absence d'information. La modification de la position d'un joueur sera rigoureusement impossible une fois le premier merkato démarré.</p>
<p>La LFP (www.lfp.fr) est notre référence en ce qui concerne les buts et le comptage des arrêts des gardiens. Whoscored est la référence en ce qui concerne le comptage des passes décisives.</p>
<br/>
<br/>
<div class="sous_titre">Annexe : l'Ethique de la Kamoulcup</div>
<ul>
<li>La Kamoulcup est un <u>jeu</u> entièrement créé et organisé par des <u>bénévoles</u> qui prennent sur leur temps de loisir et parfois leur temps de travail pour contribuer à l'amusement de tous les participants. Il est donc demandé aux inscrits de garder ceci en tête lorsqu'ils posent une réclamation.<b> Le pinaillage est parfois nécessaire, merci alors d'en user avec parcimonie.</b></li>
<li>Pour garder une ambiance agréable entre tous, les participants du topic Kamoulcup du forum se doivent d'y échanger avec respect pour leurs adversaires et sans (trop de) mauvais esprit, avec un [2] bien affiché si besoin.</li>
</ul>
</p><p>Il est PERMIS :</p>
<ul>
<li>de communiquer, d'intoxiquer, de tenter de convaincre ses adversaires d'agir dans un certain sens par tous les moyens de communication</li>
<li>de mettre en vente <b>par le biais d'une PA</b> n'importe quel joueur disponible, à n'importe quel moment, durant les périodes de merkato</li>
</ul>
<p><i>Il est donc tout à fait valide de demander à d'autres ékyp de mettre un certain joueur en vente, il est valide de demander à d'autres ékyps d'enchérir ou de ne pas enchérir sur un certain joueur, il est valide de mettre une enchère élevée sur un joueur au score faible <b>qui n'est pas remis en vente par une autre ékyp</b>, il est valide de poster une PA si on n'a que peu de chances d'en remporter l'enchère</i></p>
<br/>
<p>Il est INTERDIT :</p>
<ul>
<li>d'effectuer des opérations sur le site avec le compte d'un autre utilisateur. Tous les participants ont leur propre login et mot de passe, même ceux d'une même ékyp. Il appartient aux joueurs de veiller à la sécurité de leurs identifiants.</li>
<li>de saborder sa propre ékyp par des actions inconsidérées. Si un joueur désire abandonner, il peut le faire à tout moment durant la saison, il suffit pour cela de le déclarer sur le topic du forum ou par MP, aucune autre action n'est nécessaire.</li>
<li>d'enchérir sur une <b>remise en vente (MV)</b> à un niveau excessivement supérieur aux montant habituellement pratiqués par les autres ékyps pour des joueurs équivalents au moment de la résolution de la vente: cela fausse la libre concurrence entre tous les participants</li>
</ul>
<p>Toutes les opérations que le Suprême Baboon jugera tomber dans la catégorie des opérations interdites seront annulées. En cas de récidive, leur auteur sera exclu de l'édition en cours, et l'ékyp dissoute.</p>
<br/>
<p><i>Il est donc invalide de mettre en vente ou de revendre à la banque un de ses meilleurs joueurs en fin de merkato si on n'a pas d'alternative équivalente dans son effectif (sabordage). Il est tout aussi invalide de surpayer ostensiblement un joueur qui a été remis en vente par une autre ékyp (transfert d'argent déguisé).</i></p>
<br/>
<p><b>Le Suprême Baboon juge des cas litigieux en son âme et conscience en visant toujours à préserver l'intérêt du jeu pour le plus grand nombre.</b></p>
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
