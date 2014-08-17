<?php
	$reason = '';
	if (isset($_GET['reason'])){
		$reason = $_GET['reason'];
	}
	?>
	<div class="info">
		<div class='titre_page'>Accès interdit</div>
		<p class="error">
			<?php
				if ($reason=='needAuthentication'){
					echo 'Vous devez être identifié pour accèder à cette page';
				}
				if ($reason=='unsufficientRights'){
					echo 'Vous n\'avez pas assez de privilèges pour accèder à cette page';
				}
				if ($reason=='badTiming'){
					echo 'Cette page n\'est pas accessible pour des raisons de date';
				}
				if ($reason=='noEkypId'){
					echo 'Vous n\'avez pas d\'ékyp attribuée';
				}
				
			?>
		</p>
		<a href="index.php">Retour à l'accueil</a>
	</div>