<?php
	checkAccess(4);
?>

<div class='titre_page'>Organisation des sessions de jeu</div>
<?php
	include('./div/listSessionsDiv.php');
	echo "<div class='hr_feinte10'></div>";
	include('./div/createSessionDiv.php');
	
	
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
