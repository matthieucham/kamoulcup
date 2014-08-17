<?php
checkAccess(1);
if (! isset($_SESSION['myEkypId'])) {
	echo "Vous n'avez pas d'ekyp attribuée !";
	exit();
}
?>

<div class="info">
<div class="titre_page">Choix de draft</div>
<p><b>Vous êtes sur le point de poster les choix suivants:</b></p>
<form method="POST" action="process/saveDraft.php">
<ul>
<?php
$listIds = $_POST['pickIds'];
$listJoueurs = $_POST['pickJoueurs'];
$nbPicks = count($listIds);
for ($i=0;$i<$nbPicks;$i++) {
	$rank=$i+1;
	echo "<input type=\"hidden\" name=\"idPick[{$i}]\" value=\"{$listIds[$i]}\"/>";
	echo "<li>Choix {$rank}: ";
	$picked = joueur_getJoueurWithClub($listJoueurs[$i]);
	$desc = $picked['prenom'].' '.$picked['nomJoueur'].' ('.traduire($picked['poste']).', '.$picked['nomClub'].')';
	echo $desc;
	echo "<input type=\"hidden\" name=\"joueurPick[{$i}]\" value=\"{$listJoueurs[$i]}\"/>";
	echo "</li>";
}
?>
</ul>
<br />
<br />
<input type="submit" value="Confirmer" /></form>
</div>
