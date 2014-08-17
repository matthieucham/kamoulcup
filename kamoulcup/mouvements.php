<div class='titre_page'>Mouvements</div>

<?php
	$listPoulesQuery = $db->getArray("select id,nom from poule");
	foreach($listPoulesQuery as $poule) {
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>{$poule['nom']}</div>";
		echo "<table class='tableau_liste' cellpading='0' cellspacing='0'>";
		echo "<tr><th>Date</th><th>Type</th><th>Joueur</th><th>Acheteur</th><th>Montant</th><th>2e offre</th><th>Commentaire</th><th></th></tr>";
		$listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as idVente, ve.type, ve.montant, ek.nom as nomEkyp, ek.id as idEkyp, jo.club_id, jo.id as idJoueur, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin from joueur as jo, vente as ve, ekyp as ek where (ve.resolue=1) and ve.poule_id={$poule['id']} and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_finencheres desc"); 
		$i=0;
		if ($listVentesQuery != NULL) {
			foreach($listVentesQuery as $vente) {
				$classNum = $i %2;
				$i++;
				$club = 'Sans club';
				if ($vente['club_id'] != NULL) {
					$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
					$club = $getClubQuery[0]['nom'];
				}
				$position = traduire($vente['poste']);
				$typeVente = $vente['type'];
				$getResolutionQuery = $db->getArray("select res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, ek.nom,ek.id as ekId from resolution as res, ekyp as ek where res.vente_id='{$vente['idVente']}' and res.gagnant_id=ek.id limit 1");
				$commentaire='';
				if ($getResolutionQuery[0]['annulee']) {
					$commentaire= "Vente annulée : aucune offre.";
				} 
				if ($getResolutionQuery[0]['reserve']) {
					$commentaire= "Vente annulée : Prix de réserve pas atteint.";
				}
				$deuxieme = '-';
				if ($getResolutionQuery[0]['montant_deuxieme'] > 0) {
					$deuxieme = "{$getResolutionQuery[0]['montant_deuxieme']} Ka";
				}
				if ($vente['type'] == 'RE') {
					$gagnant = '-';
				} else {
					$gagnant = "<a href=\"index.php?page=showEkyp&ekypid={$getResolutionQuery[0]['ekId']}\">{$getResolutionQuery[0]['nom']}</a>";
				}
				echo "<tr class='ligne{$classNum}'><td>{$vente['dateFin']}</td><td>{$typeVente}</td><td><a href=\"index.php?page=detailJoueur&joueurid={$vente['idJoueur']}\">{$vente['prenom']} {$vente['nomJoueur']}</a></td><td>{$gagnant}</td><td>{$getResolutionQuery[0]['montant_gagnant']} Ka</td><td>{$deuxieme}</td><td>{$commentaire}</td><td><a href=\"javascript:affichage_popup('detailVente.php?venteid={$vente['idVente']}','popup_details');\">détails...</a></td></tr>";
			}
		}
		echo "</table></div>";
	}
?>


