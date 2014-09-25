<?php
	if (! isset($_GET['joueurid'])) {
		echo '<p class=\"error\">Pas de JoueurId !</p>';
		exit;
	}
	$joueurId = ($_GET['joueurid']);
	$getJoueurQuery = $db->getArray("select nom from joueur where id={$joueurId} limit 1");
?>

<div class="titre_page">
	KM Joueur= <?php echo $getJoueurQuery[0]['nom'] ?>
</div>
