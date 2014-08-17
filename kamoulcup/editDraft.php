<?php
checkEkyp();

$allJoueurs = listAllJoueursSorted(false);
$allClubs = listClubs();
$rank = draft_getRank($_SESSION['myEkypId']);
$storedChoices = draft_listChoices($_SESSION['myEkypId']);
?>

<div class="sectionPage">
<div class='titre_page'>Choix pour la draft</div>
<p>Bla bla blabla</p>
<form action="index.php" method="POST">
<table class="tableau_liste_centre">
	<tr>
		<th>Rang</th>
		<th>Joueur choisi</th>
	</tr>
	<?php
	$rankIndex = 0;
	for($rankIndex = 0; $rankIndex < $rank; $rankIndex++ )
	{
		if ($storedChoices != NULL)
		{
			$storedPick = $storedChoices[$rankIndex];
		} else {
			$storedPick = NULL;
		}
		include('./div/pickJoueurDiv.php');
	}
	?>
</table>
<input type="hidden" name="page" value="postDraft" /> <input
	type="submit" value="Poster" /></form>
</div>
