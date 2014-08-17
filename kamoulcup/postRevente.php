<?php
checkAccess(1);
checkEkyp();
?>
<div class="sectionPage">
<div class="titre_page">Revendre un joueur</div>
<p><b>Vous êtes sur le point de poster la remise en vente suivante:</b></p>
<form method="POST" action="process/saveRevente.php"><?php
$joueurId = $_POST['joueurId'];
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$montant = $_POST['montant'];
$montantArrondi = round(floatval($montant),1);
$reserveFl = 0;
if (isset($_POST['reserve'])) {
	$reserveFl = round(floatval($_POST['reserve']),1);
}
if ($reserveFl < $montant) {
	$reserveFl = 0;
}

echo "<a href='index.php?page=detailJoueur&joueurid={$joueurId}'>{$prenom} {$nom}</a>: ";
if ($_POST['type'] == 'MV') {
	echo "Remise en vente au prix affiché de <b>{$montantArrondi} Ka</b><br/>";
	if ($reserveFl > 0) {
		echo "Prix de réserve: <b>{$reserveFl} Ka</b>";
	} else {
		echo "Pas de prix de réserve";
	}
} else {
	echo "Revente à la Banque Arbitre au prix de <b>{$montantArrondi} Ka</b>";
}
echo "<input type=\"hidden\" name=\"joueurId\" value=\"{$joueurId}\"/>";
echo "<input type=\"hidden\" name=\"montant\" value=\"{$montantArrondi}\"/>";
echo "<input type=\"hidden\" name=\"reserve\" value=\"{$reserveFl}\"/>";
echo "<input type=\"hidden\" name=\"typeVente\" value=\"{$_POST['type']}\"/>";
echo "<div class='hr_feinte10'></div>";
echo "<input type='submit' value='Confirmer'/>";
?>
<p>En cliquant sur "Confirmer", la revente sera enregistrée et il ne
sera plus possible de revenir dessus. La revente sera effective lors de
la prochaine session de résolutions. D'ici là, cette opération est
invisible des autres participants. Il ne savent donc pas que vous
disposez d'une somme supérieure sur votre budget transfert.</p>
</form>
</div>
