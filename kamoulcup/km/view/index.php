<?php
	include_once("../../includes/db.php");
    include_once("../ctrl/accessManager.php");
    include_once("../model/KMConstants.php");
	
    checkPlayerAccess();
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
                if ($_SESSION['userrights']==0) {
                    $kmpage='fixtures';
                } else {
				    $kmpage='home';
                }
			}
			include($kmpage.'.php');
        //echo "fra={$_SESSION['myFranchiseId']} chp={$_SESSION['myChampionnatId']} insc={$_SESSION['myInscriptionId']}"
		?>
		</div>
<footer>
	<div class="footerstandard">Footer.</div>
</footer>
		
	</div>
</div>
</body>
</html>
