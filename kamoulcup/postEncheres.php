<?php
	checkAccess(1);
	if (! isset($_SESSION['myEkypId'])) {
		echo "Vous n'avez pas d'ekyp attribuée !";
		exit();
	}
	
	/*
	* Retourne la valeur float du montant passé en string.
	*/
	function convertirMontant($strMontant) {
		$out = 0;
		if (! isset($strMontant)) {
			return $out;
		}
		if ($strMontant != strval(floatval($strMontant))) {
			return $out;
		}
		if (strlen($strMontant) > 0) {
			$out = round(floatval($strMontant),1);
		}
		return $out;
	}
?>

<div class="info">
	<div class="titre_page">Poster des enchères</div>
	<p><b>Vous êtes sur le point de poster les enchères suivantes:</b></p>
	<ul>
	<form method="POST" action="process/saveEncheres.php">
	<?php
		$listIds = $_POST['idVente'];
		$listEncheres = $_POST['enchereIds'];
		$listMontants = $_POST['montantEnchere'];
		$listJoueurs = $_POST['joueurs'];
		$checkAnnul = isset($_POST['cancelled']);
		$nbVentes = count($listIds);
		for ($i=0;$i<$nbVentes;$i++) {
			echo "<input type=\"hidden\" name=\"idVente[{$i}]\" value=\"{$listIds[$i]}\"/>";
			echo "<input type=\"hidden\" name=\"idEnchere[{$i}]\" value=\"{$listEncheres[$i]}\"/>";
			echo "<li>{$listJoueurs[$i]}: ";
			echo "<input type=\"hidden\" name=\"annulVente[{$i}]\"";
			if ($checkAnnul && in_array($listIds[$i],$_POST['cancelled'])) {
					echo  "value=\"1\"/>";
					echo "Enchère annulée";
			} else {
				echo  "value=\"0\"/>";
				$convMontant = convertirMontant($listMontants[$i]);
				if ($convMontant > 0) {
					echo $convMontant.' Ka';
				} else {
					echo "Pas d'enchère";
				}
				echo "<input type=\"hidden\" name=\"montantVente[{$i}]\" value=\"{$convMontant}\"/>";
			}
			echo "</li>";
		}
	?>
	<br/><br/>
	<input type="submit" value="Confirmer"/>
	</form>
	</ul>
</div>