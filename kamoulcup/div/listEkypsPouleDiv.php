<div class="sectionPage">
	<div class='sous_titre'>Ekyps de cette poule</div>
	<ul>
		<?php
				$listEkypsQuery = $db->getArray("select nom,logo from ekyp where poule_id = '{$storedPoule[0]['id']}' order by nom");
				if ($listEkypsQuery != NULL) {
					foreach($listEkypsQuery as $ekyp) {
						echo "<li>{$ekyp[0]}</li>";
					}
				}
		?>
	</ul>
	<?php 
		$getNbEkyp = $db->getArray("select count(*) from ekyp where poule_id = '{$storedPoule[0]['id']}'");
		$getMaxEkyp = $db->getArray("select valeur from parametres where cle = 'max_ekyp_poule' limit 1");
	?>
	<p>Remplissage: <?php echo $getNbEkyp[0][0].'/'.$getMaxEkyp[0]['valeur'] ?></p>
</div>