<?php
	checkAccess(1);
	if (! isset($_GET['sessionid'])) {
		echo '<span class=\"error\">Pas de sessionId !</span>';
		exit;
	}
	if (! isset($_SESSION['myEkypId'])) {
		echo "Vous n'avez pas d'ekyp attribuée !";
		exit();
	}
	$getSessionQuery = $db->getArray("select se.numero, po.nom, date_format(se.date_pas,'%Y/%m/%d %H:%i'),date_format(se.date_encheres,'%Y/%m/%d %H:%i'),date_format(se.date_resolution,'%Y/%m/%d %H:%i'),(se.date_encheres < now()), (se.date_resolution > now()), (se.date_pas < now()) from session as se, poule as po where se.poule_id=po.id and se.id='{$_GET['sessionid']}' limit 1");
	$listSessionsVenteQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant, ek.nom as nomEkyp, jo.club_id, jo.id as joueurId from joueur as jo, vente as ve, ekyp as ek where ve.session_id='{$_GET['sessionid']}' and ve.joueur_id=jo.id and ve.auteur_id=ek.id and (ve.type='PA' or ve.type='MV') order by ve.date_soumission asc");
	
?>
	<div class="sectionPage">
		<div class="titre_page">Poster des enchères</div>
		<form action="index.php" method="POST">
		<table class="tableau_liste_centre">
			<tr><th colspan="8">Joueur</th><th>Poste</th><th>Club</th><th>Prix</th><th>Soumetteur</th><th>Enchere<br/>proposée</th><th>Nouveau<br/>montant</th><th>Annuler</th></tr>
			<?php
			if ($listSessionsVenteQuery != NULL) {
				$i=0;
				$enchereIds = Array();
				$joueurs = Array();
				$montantEnchere = Array();
				$cancelled = Array();
				$idVente = Array();
				$cptLigne = 0;
				foreach($listSessionsVenteQuery as $vente) {
					$montant = 0;
					$getEnchereQuery = $db->getArray("select id,montant from enchere where vente_id='{$vente['venteId']}' and auteur='{$_SESSION['myEkypId']}' limit 1");
					$club = 'Sans club';
					if ($vente['club_id'] != NULL) {
						$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
						$club = $getClubQuery[0]['nom'];
					}
					$classNum = $cptLigne % 2;
					echo "<tr class='ligne{$classNum}'><td colspan='8'>";
					$cptLigne++;
					echo "<input type =\"hidden\" name=\"enchereIds[{$i}]\" value=\"";
					if (isset ($getEnchereQuery[0])) {
						echo $getEnchereQuery[0]['id'];
					} else {
						echo '-1';
					}
					echo "\" />";
					echo "<input type =\"hidden\" name=\"idVente[{$i}]\" value=\"{$vente['venteId']}\" />";
					echo "<input type =\"hidden\" name=\"joueurs[{$i}]\" value=\"{$vente['prenom']} {$vente['nomJoueur']}\" />";
					echo "<a href='index.php?page=detailJoueur&joueurid={$vente['joueurId']}'>{$vente['prenom']} {$vente['nomJoueur']}</a></td>";
					$poste = traduire($vente['poste']);
					echo "<td>{$poste}</td><td>{$club}</td><td>{$vente['montant']} Ka</td><td>{$vente['nomEkyp']}</td><td>";
					if (isset ($getEnchereQuery[0])) {
						$montant = $getEnchereQuery[0]['montant'];
						echo $montant.' Ka';
					} else {
						echo "-";
					}
					echo "</td>";
					echo "<td><input type=\"text\" size=\"4\" name=\"montantEnchere[{$i}]\" ";
					if ($montant > 0) {
						echo "value=\"{$montant}\"";
					}
					echo "/></td>";
					echo "<td><input type=\"checkbox\" name=\"cancelled[]\" value=\"{$vente['venteId']}\" ";
					if ($montant == 0) {
						echo "disabled=\"true\"";
					}
					echo "/></td></tr>";
					$i++;
				}
			}
			?>
		</table>
		<input type="hidden" name="sessionId" value="<?php echo $_GET['sessionid'];?>"/>
		<input type="hidden" name="page" value="postEncheres"/>
		<input type="submit" value="Poster"/>
	</form>
	</div>
	<?php
	if (isset($_GET['ErrorMsg'])){
		echo "<div class=\"error\">{$_GET['ErrorMsg']}</div>";
	}
	?>