<html>
<head>
	<title>Kamoulcup Manager : un jeu d'avenir</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="view/css/default.css" type="text/css" rel="stylesheet">
	<link href="view/css/themes/km/remodern.css" type="text/css" rel="stylesheet">	
</head>
<body>
    <h1>Kamoulcup Manager : un jeu d'avenir ?</h1>
<?php
	if (isset($_SESSION['km'])&& ($_SESSION['km']==1)) {
		// Loggé avec accès au jeu
        header("Location: view/index.php");
        die();
	} else {
		// Pas accès au jeu : montrer la page de login.
        echo "<form method='post' action='ctrl/identify.php'>";
		echo "<p><label for='loginField'>Login: </label>";
        echo "<input id='loginField' name='login' type='text' size='30'/></p>";
        echo "<p><label for='pwdField'>Mot de passe: </label>";
        echo "<input id='pwdField' name='pwd' type='password' size='30'/></p>";
        echo "<p><input type='submit' value='Entrer'/></p>";
        echo "</form>";
	}
?>
</body>
</html>