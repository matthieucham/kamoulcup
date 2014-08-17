<?php
$listPoules = poule_listPoules();

foreach($listPoules as $poule) {
	$draftQ = transfert_listTransfertsDraft($poule['id']);
	echo "<div class='sectionPage'>";
	echo "<div class='sous_titre'> Bilan de la draft de la poule {$poule['nom']}</div>";
	echo "<table class='tableau_liste' cellpading='0' cellspacing='0'>";
	echo "<tr><th>Rang</th><th>Ekyp</th><th>Joueur drafté</th><th>N° de choix</th></tr>";
	$i=0;
	if ($draftQ != NULL) {
		foreach($draftQ as $draft) {
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
			echo "<tr class='ligne{$classNum}'><td>{$draft['draft_order']}</td><td><a href=\"index.php?page=showEkyp&ekypid={$draft['idEkyp']}\">{$draft['nomEkyp']}</a></td><td><a href=\"index.php?page=detailJoueur&joueurid={$draft['idJoueur']}\">{$draft['prenom']} {$draft['nomJoueur']}</a></td><td>{$draft['choix_draft']}</td></tr>";
		}
	}
	echo "</table></div>";
}

?>
