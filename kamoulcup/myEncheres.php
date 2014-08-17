<?php
	checkAccess(1);
	checkEkyp();
	
	$getEkypQuery = $db->getArray("select po.nom as nomPoule, ek.nom, ek.logo, ek.budget, ek.presentation, ek.score from ekyp as ek, poule as po where ek.id='{$_SESSION['myEkypId']}' and ek.poule_id=po.id limit 1");
?>

	<div class="titre_page">
		<?php echo "Suivi des enchères de l'ékyp: <a href='index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}'>{$getEkypQuery[0]['nom']}</a>"; ?>
	</div>
	<div class="section_page">
	<?php
		$listEnchQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, ve.id as idVente, ek.id as idEkyp, ek.nom as nomEkyp, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin, res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, en.montant, en.exclue from joueur as jo, vente as ve, ekyp as ek, resolution as res, enchere as en where en.auteur={$_SESSION['myEkypId']} and en.vente_id=ve.id and (ve.resolue=1) and res.vente_id=en.vente_id and ve.joueur_id=jo.id and res.gagnant_id=ek.id order by ve.date_finencheres desc, ve.date_soumission desc"); 
		
		echo "<table class='tableau_liste' cellpading='0' cellspacing='0'>";
		echo "<tr><th>Date</th><th>Joueur</th><th>Enchere</th><th></th><th>Gagnée par</th><th>Montant</th><th>Diff</th><th></th></tr>";
		if ($listEnchQuery != NULL) {
			$i=0;
			foreach($listEnchQuery as $myEnch) {
				$classNum = $i %2;
				$i++;
				$montantEnchere = round($myEnch['montant'],1);
				$montantGagnant = round($myEnch['montant_gagnant'],1);
				$montantDeuxieme = round($myEnch['montant_deuxieme'],1);
				if ($_SESSION['myEkypId'] == $myEnch['idEkyp']) {
					$diff = '<b>+'.($montantGagnant - $montantDeuxieme).'</b>';
				} else {
					$diff = $montantEnchere - $montantGagnant;
				}
				$excl = $myEnch['exclue'];
				$picto = 'images/accept.png';
				if ($excl) {
					$picto = 'images/cross.png';
					$diff = '';
				}
				echo "<tr class='ligne{$classNum}'><td>{$myEnch['dateFin']}</td><td>{$myEnch['prenom']} {$myEnch['nomJoueur']}</td><td>{$montantEnchere} Ka</td><td><img src='{$picto}'/></td>";
				if (intval($myEnch['reserve']) || intval($myEnch['annulee']) ) {
					echo "<td colspan='3'>Vente annulée</td>";
				} else {
					echo "<td>{$myEnch['nomEkyp']}</td><td>{$montantGagnant} Ka</td><td>{$diff}</td>";
				}
				echo "<td><a href=\"javascript:affichage_popup('detailVente.php?venteid={$myEnch['idVente']}','popup_details');\">détails...</a></td></tr>";
			}
		}
		
		echo "</table>";
	?>
	</div>
	