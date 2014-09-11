<?php
	checkAccess(1);
	checkEkyp();
	$userPouleId = intval($_SESSION['pouleId']);
	$listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant,date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin, ek.nom as nomEkyp, jo.club_id, jo.id as joueurId from joueur as jo, vente as ve, ekyp as ek where ve.resolue=0 and ve.departage_attente=0 and ve.date_soumission<now() and ve.date_finencheres>now() and ve.joueur_id=jo.id and ve.auteur_id=ek.id and (ve.type='PA' or ve.type='MV') and ve.poule_id={$userPouleId} order by ve.date_soumission asc");
?>
	<div class="sectionPage">
		<div class="titre_page">Enchères en cours</div>
		<form action="index.php" method="POST">
		<table class="tableau_liste_centre">
			<tr><th>Type</th><th>Joueur</th><th>Poste</th><th>Club</th><th>Prix</th><th>Fin</th><th>Enchere<br/>proposée</th><th>Nouveau<br/>montant</th><th>Annuler</th></tr>
			<?php
			if ($listVentesQuery != NULL) {
				$i=0;
				$enchereIds = Array();
				$joueurs = Array();
				$montantEnchere = Array();
				$cancelled = Array();
				$idVente = Array();
				$cptLigne = 0;
				foreach($listVentesQuery as $vente) {
					$montant = 0;
					$getEnchereQuery = $db->getArray("select id,montant from enchere where vente_id='{$vente['venteId']}' and auteur='{$_SESSION['myEkypId']}' limit 1");
					$club = 'Sans club';
					if ($vente['club_id'] != NULL) {
						$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
						$club = $getClubQuery[0]['nom'];
					}
					$classNum = $cptLigne % 2;
					echo "<tr class='ligne{$classNum}'><td>{$vente['type']}</td><td>";
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
					echo "<td>{$poste}</td><td>{$club}</td><td>{$vente['montant']} Ka</td><td>{$vente['dateFin']}</td><td>";
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
		<input type="hidden" name="page" value="postEncheres"/>
		<input type="submit" value="Poster"/>
	</form>
	</div>
	<?php
	if (isset($_GET['ErrorMsg'])){
		echo "<div class=\"error\">{$_GET['ErrorMsg']}</div>";
	}
	?>