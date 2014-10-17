<?php
	include_once("../../includes/db.php");
	
    session_start();
	if (!isset($_SESSION['km']) || !($_SESSION['km']==1)) {
		// Pas accès au jeu
        header("Location: ../index.php");
        die();
	}
?>
<!DOCTYPE html>
<html>
<?php include("fragments/head.php")?>
<body>
<div id="container">
	<?php include("fragments/header.php")?>	
	<div id="main">
		<div id="main-content">
		<?php 
			if (isset($_GET['kmpage'])) {
				$kmpage = $_GET['kmpage'];
			} else {
				$kmpage='home';
			}
			include($kmpage.'.php');
		?>
		</div>
<!--<footer>
	<div class="footerstandard">Footer.</div>
</footer>-->
		
	</div>
</div>
</body>
</html>
