<?php

?>
<div id='liste_ventes'><?php
if ($listVentesQuery != NULL) {
	foreach($listVentesQuery as $vente) {
		echo "<div class=\"cadreVente\">";
		$position = traduire($vente['poste']);
		$club = 'Sans club';
		if ($vente['club_id'] != NULL) {
			$getClubQuery = $db->getArray("select cl.id, cl.nom from club as cl where cl.id='{$vente['club_id']}' limit 1");
			$club = $getClubQuery[0]['nom'];
		}
		echo "<b>{$vente['type']} de l'ekyp <a href=\"index.php?page=showEkyp&ekypid={$vente['ekypId']}\">{$vente['nomEkyp']}</a> sur <a href=\"index.php?page=detailJoueur&joueurid={$vente['joueurId']}\">{$vente['prenom']} {$vente['nomJoueur']}</a> ({$position}, {$club}): {$vente['montant']} Ka.</b>";
		if ($enchereAllowed && ($encheresEnCoursQuery != NULL)) {
			foreach ($encheresEnCoursQuery as $enchere) {
				if ($vente['venteId'] == $enchere['vente_id']) {
					echo "  [{$enchere['montant']} Ka]";
				}
			}
		}
		//echo '<br/><img src="'.getURLPhotoJoueur($vente['id_lequipe']).'" alt="photo '.$vente['nomJoueur'].'\"/>';
		echo "<br/>Enchères jusqu'au <b>{$vente['finDate']}</b>";
		echo "</div>";
	}
} else {
	echo "<p>Pas de joueur en vente</p>";
}

?></div>
