<?php
	$listPoulesQuery = $db->getArray("select id,nom from poule order by id asc");
	

	foreach ($listPoulesQuery as $poule) {
		echo "<div class='sous_titre'>Les derniers transferts de {$poule['nom']}</div>";
		echo "» <a href=\"index.php?page=mouvements\">Voir tous les mouvements</a><br/>";
		
		include('div/flexResolutionsDiv.php');
		
		
		
		// echo "<div id='liste_ventes'>";
		// $listVentesQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as idVente, ve.type, ve.montant, ek.nom as nomEkyp, ek.id as idEkyp, jo.club_id, jo.id as idJoueur, jo.id_lequipe as eqJoueur, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin, ve.departage_attente from joueur as jo, vente as ve, ekyp as ek where ((ve.resolue=1) or (ve.resolue=0 and ve.departage_attente>0)) and ve.poule_id={$poule['id']} and ve.joueur_id=jo.id and ve.auteur_id=ek.id order by ve.date_finencheres desc limit 20"); 
		// if ($listVentesQuery != NULL) {
		// foreach($listVentesQuery as $vente) {
			// $club = 'Sans club';
			// if ($vente['club_id'] != NULL) {
				// $getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
				// $club = $getClubQuery[0]['nom'];
			// }
			// echo "<div class=\"cadreVente\">";
			// $position = traduire($vente['poste']);
			// $typeVente = traduire ($vente['type']);
			// echo "{$typeVente} de l'ekyp <a href=\"index.php?page=showEkyp&ekypid={$vente['idEkyp']}\">{$vente['nomEkyp']}</a> sur <a href=\"index.php?page=detailJoueur&joueurid={$vente['idJoueur']}\">{$vente['prenom']} {$vente['nomJoueur']}</a> ({$position}, {$club}): {$vente['montant']} Ka.<br/>";
			// echo '<img src="'.getURLPhotoJoueur($vente['eqJoueur']).'" alt="photo '.$vente['nomJoueur'].'\"/>';
			// if ($typeVente != 'RE') {
				// echo "<br/>Enchères arrêtées le {$vente['dateFin']}";
			// }
			// echo "</div>";
					
			// $getResolutionQuery = $db->getArray("select res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, ek.nom,ek.id as ekId from resolution as res, ekyp as ek where res.vente_id='{$vente['idVente']}' and res.gagnant_id=ek.id limit 1");
			// if ($getResolutionQuery != NULL) {
				// echo "<div class=\"resolution\">";
				// if ($getResolutionQuery[0]['annulee']) {
					// echo "Aucune offre, MV annulée";
				// } else{ 
					// if ($getResolutionQuery[0]['reserve']) {
						// echo "MV annulée car le prix de réserve imposé par le vendeur n'a pas été atteint";
					// } else {
						// if ($vente['type'] == 'RE') {
							// echo "Revendu à la banque pour {$getResolutionQuery[0]['montant_gagnant']} Ka";
						// } else {
							// echo "Rejoint <a href=\"index.php?page=showEkyp&ekypid={$getResolutionQuery[0]['ekId']}\">{$getResolutionQuery[0]['nom']}</a> pour {$getResolutionQuery[0]['montant_gagnant']} Ka";
							// if ($getResolutionQuery[0]['montant_deuxieme'] > 0) {
								// echo " (2e offre: {$getResolutionQuery[0]['montant_deuxieme']} Ka)";
							// } else {
								// echo " (Pas de 2e offre)";
							// }
						// }
					// }
				// }
				// echo "</div>";
			// } else {
				// echo "<div class=\"resolution\">";
				// echo "Non résolue";
				// if ($vente['departage_attente'] > 0) {
					// echo " : ballotage entre plusieurs ékyps." ;
				// }
				// echo "</div>";
			// }
		// }
		// echo "</div>";
		
		
		
		
		
		echo "<br/>» <a href=\"index.php?page=mouvements\">Voir tous les mouvements</a><br/>";
	//}
	}
?>
