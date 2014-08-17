<?php
$nomApprox = $_POST['approxNom'];
if (!get_magic_quotes_gpc()) {
    $nomApprox = addslashes($nomApprox);
}

$nomApprox =htmlspecialchars($nomApprox, ENT_COMPAT, 'UTF-8');
$typeRecherche = $_POST['typeRecherche'];

$rechJoueurQuery = "select jo.id,jo.prenom,jo.nom as nomJoueur,jo.poste,cl.nom as nomClub from joueur as jo, club as cl where jo.nom like '{$nomApprox}%' and jo.club_id = cl.id limit 10";
$rechClubQuery = "select id,nom from club where nom like '{$nomApprox}%' limit 10";

$noresult = false;
if ($typeRecherche == 'j') {
	$resultat = $db->getArray($rechJoueurQuery);
	$redirect = "?page=detailJoueur&joueurid=";
}
if ($typeRecherche == 'c') {
	$resultat = $db->getArray($rechClubQuery);
	$redirect = "?page=detailClub&clubid=";
}
	if (count($resultat) == 1) {
		echo "<script>window.location.replace('index.php{$redirect}{$resultat[0][0]}');</script>";
		exit();
	} else {
		echo "<div class='titre_page'>Résultats de la recherche</div>";
		$nb = count($resultat);
		if ($nb > 0) {
			echo "<p>La recherche portant sur '<i>{$nomApprox}</i>' a retourné {$nb} résultats :</p>";
			echo "<ul>";
			if ($typeRecherche == 'j') {
			foreach ($resultat as $joueur) {
				$position = traduire($joueur[3]);
				echo "<li><a href='index.php?page=detailJoueur&joueurid={$joueur[0]}'>{$joueur[1]} {$joueur[2]} ({$position}, {$joueur[4]})</a></li>";
			}
			}
			if ($typeRecherche == 'c') {
			foreach ($resultat as $club) {
				echo "<li><a href='index.php?page=detailClub&clubid={$club[0]}'>{$club[1]}</a></li>";
			}
			}
			echo "</ul>";
		} else {
			echo "<p>La recherche portant sur '<i>{$nomApprox}</i>' n'a rien donné.</p>";
		}
	}




?>