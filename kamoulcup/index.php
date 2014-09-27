<?php
include("includes/db.php");
include('process/checkAccess.php');
include ('vocabulaire.php');
include ('process/computeDate.php');
include ('process/api_joueur.php');
include ('process/api_club.php');
include ('process/api_draft.php');
include ('process/api_poule.php');
include ('process/api_transfert.php');
include ('process/api_stats.php');
include ('process/api_journee.php');
include ('process/api_ekyp.php');
include( 'tools/GoogChart.class.php' );
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Kamoulcup</title>
<style type="text/css" media="all">
@import "lodemars.css";
</style>
<script language="JavaScript">
	<!--

		function affichage_popup(nom_de_la_page, nom_interne_de_la_fenetre)
		{
			window.open (nom_de_la_page, nom_interne_de_la_fenetre, config='height=500, width=600, toolbar=no, menubar=no, scrollbars=yes, resizable=yes, location=no, directories=no, status=no')
		}
	-->
	</script>
</head>
<body>
<div id="frisetop"></div>
<div id="header">
<ul id="menu">
	<li><a
		href="http://www.kamouloxdufoot.com/kdf/viewtopic.php?t=3771&start=0"><img
		src="images/forum.png" /></a></li>
	<li><a href="http://www.kamoulcup.com/l1/archives/"><img src="images/palmares.png" /></a></li>
	<li><a href="regles.php"><img src="images/regles.png" /></a></li>
	<?php
	if (isset($_SESSION['myEkypId'])) {
		echo "<li><a href='index.php?page=myEkyp'><img src='images/myekyp.png' /></a></li>  ";
	}
	?>
</ul>
<a href='index.php?page=accueil'> <img src='images/blanc.gif' width=300
	height=110 align='left' border=0></img> </a></div>
<!--fin header-->

<div id="containeur">

<div id="coldroite"><?php
if (isset($_SESSION['myEkypId'])) {
	$departageQuery = $db->getArray("select id from departage_vente where (ekyp_id='{$_SESSION['myEkypId']}') and ( montant_nouveau IS NULL ) and (date_expiration > now())");
	if ($departageQuery != NULL) {
		$nb = count($departageQuery);
		include('./div/ekypMessageDiv.php');
	}
}
?>
<div class='classement'><a href='index.php?page=ventesEnCours'><img
	src='./images/sallemarche.jpg' alt='Le marchï¿½' /></a></div>

<div class='hr_feinte'></div>
<?php include('./div/classementEkypsDiv.php'); ?>
<div class='hr_feinte'></div>
<?php include('./div/rechercheDiv.php'); ?>
<div class='hr_feinte'></div>
<?php include('./div/classementJoueursDiv.php'); ?></div>
<!-- fin coldroite -->
<div id="colgauche"><?php
if (isset($_SESSION['userrights'])) {
	echo "<a href='process/disconnect.php' ><img src='images/deconnexion.png' /></a>";
} else {
	echo "<a href='index.php?page=identification'><img src='images/connexion.png' /></a>";
}
?> <?php
// C'est ici qu'on insère le contenu variable (fausse frame).
if(isset($_GET['ErrorMsg'])){
	echo "<br/><div class='error'>";
	echo $_GET['ErrorMsg'];
	echo "</div><br/>";}
$contenuPage = 'accueil';
if (isset($_GET['page'])) {
	$contenuPage = $_GET['page'];
} else {
	if (isset($_POST['page'])) {
		$contenuPage = $_POST['page'];
	}
}
include($contenuPage.'.php');
?></div>
<!-- fin colgauche -->
<hr />
<?php
if (isset($_SESSION['userrights'])) {
	echo "<ul id='menufooter'>";
	echo "<li><a href='process/disconnect.php' ><img src='images/deconnexion.png' /></a></li>";
	echo "<li><a href='index.php?page=baboon' ><img src='images/baboon.png'/></a></li>";
	echo "</ul>";
} else {
	echo "<ul id='menufooter'><li><a href='index.php?page=identification'><img src='images/connexion.png' /></a></li></ul> ";
}
?></div>
</div>
<!--fin containeur-->

<div id="footer"></div>
<!--fin footer-->
<div id="frisebottom">
<div id="credits">Programmation: Charlie Brown - Graphismes: Lo de Mars
- Idée originale: Peterelephanto &nbsp;</div>
<!-- frise bottom -->

</body>
</html>
