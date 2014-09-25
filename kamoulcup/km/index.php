<html>
<head>
<title>Kamoulcup Manager : un jeu d'avenir</title>
</head>
<body>
<?php
	if (isset($_SESSION['km'])&& ($_SESSION['km']==1)) {
		// Loggé avec accès au jeu
	} else {
		// Pas accès au jeu : montrer la page de login.
		include('../identification.php');
	}
?>
</body>
</html>