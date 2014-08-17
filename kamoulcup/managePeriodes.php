<?php
	checkAccess(4);
?>

<div class='titre_page'>Gérer les périodes de vente</div>
<?php
	include('./div/listPeriodesDiv.php');
	echo "<div class='hr_feinte10'></div>";
	include('./div/createPeriodeDiv.php');
	
	
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
