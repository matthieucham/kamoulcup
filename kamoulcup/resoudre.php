<?php
	checkAccess(4);
	
	// A partir de la on est tranquille.
	//Récupération de toutes les ventes expirées en attente de résolution
	$listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as venteId, ve.type, ve.montant, ek.nom as nomEkyp, jo.club_id,ve.departage_attente from joueur as jo, vente as ve, ekyp as ek where ve.resolue=0 and ve.date_finencheres<now() and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_finencheres asc");
?>
<div class="titre_page">Ventes en attente de résolution</div>
<div class="sectionPage">
	<form method="POST" action="process/resoudreVentes.php">
	<ul>
	<?php
		if ($listVentesQuery != NULL) {
			$aResoudre = array();
			$aResoudreCount = 0;
			foreach($listVentesQuery as $vente) {
				$club = 'Sans club';
				if ($vente['club_id'] != NULL) {
					$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
					$club = $getClubQuery[0]['nom'];
				}
				echo "<li>{$vente['type']} de l'ekyp <b>{$vente['nomEkyp']}</b> sur {$vente['prenom']} {$vente['nomJoueur']} ({$vente['poste']}, {$club}): {$vente['montant']} Ka.";
				echo "</li>";
			}
			echo "<input type=\"submit\" value=\"Lancer la résolution\"/>";				
		} else {
			echo "<p>Aucune vente en attente.</p>";
		}
	?>
	</ul>
	</form>
</div>