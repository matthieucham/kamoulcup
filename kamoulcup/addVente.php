<?php
	checkEkyp();
?>
<div class='titre_page'>Déposer une PA</div>
<div class="sectionPage">
	<form method="GET" action="index.php">
			Club du joueur: <select size=1 name="club">
				<?php
				$listClubsQuery = $db->getArray("select id,nom from club order by nom");
				foreach($listClubsQuery as $club) {
					echo "<option value={$club[0]} ";
					if (isset ($_GET['club'])) {
						if ($_GET['club'] == $club[0]) {
							echo "selected";
						}
					}
					echo ">{$club[1]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="addVente"/>
			<input type="submit" value="Afficher joueurs"/>
	</form>
</div>
<?php
if (isset($_GET['club'])) {
	$pouleId = $_SESSION['pouleId'];
	$transfertsIndependantsQuery = $db->getArray("select valeur from parametres where cle='transferts_independants'");
	$isIndep = intval($transfertsIndependantsQuery[0][0]);
	$myQuery ="select distinct jo.id, jo.prenom, jo.nom, jo.poste, cl.nom, jo.score from joueur as jo, club as cl where jo.club_id=cl.id and cl.id='{$_GET['club']}' and jo.id not in (select tr.joueur_id from transfert as tr where";
	if ($isIndep > 0) {
		$myQuery.=" tr.poule_id={$pouleId} and"; 
	}
	$myQuery .=  " (tr.ekyp_id is not NULL)) and jo.id not in (select ve.joueur_id from vente as ve where (ve.resolue=0)";
	if ($isIndep > 0) {
		" and (ve.poule_id={$pouleId})";
	}
	$myQuery .= ") order by field(jo.poste,'G','D','M','A'),jo.nom";
	$listJoueursLibresQuery = $db->getArray($myQuery);
	

	echo "<form method=\"POST\" action=\"index.php\">";
	$budgetQuery = $db->getArray("select budget from ekyp where id='{$_SESSION['myEkypId']}'");
	if ($listJoueursLibresQuery != NULL) {
		echo "<div class=\"sectionPage\">";
		echo "<div class='sous_titre'>Joueurs libres</div>";
		echo "<table class='tableau_liste'>";
		echo "<tr>";
		echo "<th></th><th>Joueur</th><th>Poste</th><th></th>";
		echo "</tr>";
		$cptLigne = 0;
		foreach($listJoueursLibresQuery as $joueurLibre) {
			$classNum = $cptLigne % 2;
			$poste = traduire($joueurLibre[3]);
			//$score = number_format(round($joueurLibre[5],2),2);
			echo "<tr class='ligne{$classNum}'><td><input type=\"radio\" name=\"joueurId\" value=\"{$joueurLibre[0]}\"/></td><td><a href='index.php?page=detailJoueur&joueurid={$joueurLibre[0]}'>{$joueurLibre[1]} {$joueurLibre[2]}</a></td><td>{$poste}</td><td align='right'>?</td></tr>";
			$cptLigne++;
		}
		echo "</table>";
		echo "</div>";
		echo "<div class=\"sectionPage\">";
		echo "<div class='sous_titre'>Proposition d'achat</div>";
		echo "<p>Vous disposez de {$budgetQuery[0][0]} Ka</p><br/>";
		echo "<p>Montant: <input type=\"text\" name=\"montant\" size=\"4\"/> Ka</p><br/>";
		echo "</div>";
		
		echo "<input type='hidden' name='page' value='postVente'/>";
		echo "<input type=\"submit\" value=\"Mettre en vente\"/>";
	}
	echo "</form>";
}
	if (isset($_GET['ErrorMsg'])){
		echo "<div class=\"error\">{$_GET['ErrorMsg']}</div>";
	}
?>