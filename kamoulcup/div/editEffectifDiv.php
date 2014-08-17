<?php
	$ekypId = $_GET['id'];
	$listJoueursQuery = $db->getArray("select jo.id as idJoueur, jo.prenom, jo.nom as nomJoueur, jo.poste, jo.score, tr.prix_achat from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} order by field(jo.poste,'G','D','M','A')");
?>
<div class='sectionPage'>
	<form method="POST" action="process/editTransferts.php">
		<table class="tableau_liste">
		<?php
			if ($listJoueursQuery != NULL) {
				echo "<tr><th>Verrouiller</th><th>Joueur</th><th>Poste</th><th>Prix d'achat</th><th>Score</th><th>Libérer</th></tr>";
				$cptLigne = 0;
				foreach($listJoueursQuery as $joueur) {
					$classNum = $cptLigne % 2;
					$cptLigne++;
					$score = number_format(round($joueur['score'],2),2);
					$prix = round($joueur['prix_achat'],1);
					echo "<tr class='ligne{$classNum}'><td><input type=\"checkbox\" name=\"verrou[]\" value=\"{$joueur['idJoueur']}\"/></td><td>{$joueur['prenom']} {$joueur['nomJoueur']}</td><td>{$joueur['poste']}</td><td>{$prix} Ka</td><td>{$score}</td><td><input type=\"checkbox\" name=\"libre[]\" value=\"{$joueur['idJoueur']}\"/></td></tr>";
				}
			}
		?>
		</table>
		<p><input type="hidden" name="ekypid" value="<?php echo $ekypId; ?>"/></p>
		<p><input type="submit" value="Mettre à jour"/></p>
	</form>
</div>
