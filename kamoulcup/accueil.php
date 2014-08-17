<?php
	include('process/validateForm.php');
	include('process/formatStyle.php');
?>
<div class='section_page'>
<div class="colgauche_container">
	<div id="perfDomicile">
		<?php include('./div/derniersResultatsDiv.php'); ?>
	</div>
	<div id="perfExterieur">
		<?php include('./div/enVenteDiv.php'); ?>
	</div>
</div>
</div>
<div class='hr_feinte3'>
</div>
<div class='section_page'>
	<?php 
		include('./div/derniersMouvementsDiv.php'); 
		//include('./palmares.php'); 
	?>
</div>

