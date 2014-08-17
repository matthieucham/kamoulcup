<?php
	include("includes/db.php");
	include("vocabulaire.php");
	$getVenteQuery = $db->getArray("select jo.prenom, jo.nom as nomJoueur, jo.poste, ve.id as idVente, ve.type, ve.montant, ek.nom as nomEkyp, ek.id as idEkyp, jo.club_id, jo.id as idJoueur, date_format(ve.date_soumission,'%d/%m %H:%i:%s') as dateDeb, date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin from joueur as jo, vente as ve, ekyp as ek where (ve.resolue=1) and ve.id={$_GET['venteid']} and ve.joueur_id=jo.id and ve.auteur_id=ek.id limit 1");
	if ($getVenteQuery == NULL) {
		exit();
	}
?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Kamoulcup</title>
	<style type="text/css" media="all">
		@import "lodemars.css";
	</style>
</head>
<body onload="window.focus()">
	<div id='popup_container'>
		<div class='sous_titre'>
		<?php echo "Details de la vente n°{$_GET['venteid']}"?>
		</div>
		<div class='section_page'>
			
			<?php
				$annulee = false;
				$reserve = false;
				echo "<table class='tableau_horizon'>";
				echo "<tr class='ligne_bilan'><th>Joueur</th><td align='right'>{$getVenteQuery[0]['prenom']} {$getVenteQuery[0]['nomJoueur']}</td></tr>";
				echo "<tr><th>Date de mise en vente</th><td align='right'>{$getVenteQuery[0]['dateDeb']}</td></tr>";
				echo "<tr><th>Mis en vente par</th><td align='right'>{$getVenteQuery[0]['nomEkyp']}</td></tr>";
				$typeVente = traduire($getVenteQuery[0]['type']);
				echo "<tr><th>Type de vente</th><td align='right'>{$typeVente} ({$getVenteQuery[0]['type']})</td></tr>";
				echo "<tr><th>Montant</th><td align='right'>{$getVenteQuery[0]['montant']} Ka</td></tr>";
				if ($getVenteQuery[0]['type'] != 'RE') {
					$getResolutionQuery = $db->getArray("select res.montant_gagnant, res.montant_deuxieme, res.reserve, res.annulee, ek.nom,ek.id as ekId from resolution as res, ekyp as ek where res.vente_id='{$_GET['venteid']}' and res.gagnant_id=ek.id limit 1");
					echo "<tr><th>Date de clôture</th><td align='right'>{$getVenteQuery[0]['dateFin']}</td></tr>";
					
					if (intval($getResolutionQuery[0]['annulee'])) {
						$annulee = true;
						echo "<tr><td colspan='2'>Vente annulée : aucune offre.</td></tr>";
					}
					if (intval($getResolutionQuery[0]['reserve'])) {
						$reserve = true;
						echo "<tr><td colspan='2'>Vente annulée : Prix de réserve pas atteint.</td></tr>";
					}
					if ((!$annulee) && (!$reserve)) {
						echo "<tr class='ligne_bilan'><th>Vainqueur</th><td align='right'>{$getResolutionQuery[0]['nom']}</td></tr>";
						echo "<tr class='ligne_bilan'><th>Prix d'achat</th><td align='right'>{$getResolutionQuery[0]['montant_gagnant']} Ka</td></tr>";
						$deuxieme = '-';
						if ($getResolutionQuery[0]['montant_deuxieme'] > 0) {
							$deuxieme = "{$getResolutionQuery[0]['montant_deuxieme']} Ka";
						}
						echo "<tr><th>Deuxième offre</th><td align='right'>{$deuxieme}</td></tr>";
					}
					echo "</table>";
					if ((!$annulee) && (!$reserve)) {
					$getEncheresQuery = $db->getArray("select montant,exclue from enchere where vente_id={$_GET['venteid']} order by montant desc");
					echo "<p><b>Détail des enchères</b></p>";
					echo "<table class='tableau_liste' style='width:150px;'>";
					echo "<tr><th>Montant</th><th>Valide</th></tr>";
					if ($getEncheresQuery != NULL) {
						$i=0;
						foreach ($getEncheresQuery as $ench) {
							$classNum = $i %2;
							$i++;
							$excl = $ench['exclue'];
							$picto = 'images/accept.png';
							if ($excl) {
								$picto = 'images/cross.png';
							}
							echo "<tr class='ligne{$classNum}'><td>{$ench['montant']} Ka</td><td align='right'><img src='{$picto}'/></td></tr>";
						}
					}
					echo "</table>";
					}
				} else {
					echo "</table>";
				}				
				
				
				
			?>
			</table>
		</div>
	</div>
</body>
</html>