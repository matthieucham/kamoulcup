<?php
	checkAccess(2);
	include 'process/formatStyle.php';
	
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
	if (! isset($_GET['matchId'])){
		echo '<span class=\"error\">Pas de matchId !</span>';
	} else {
		echo "<div class='titre_page'>Saisie des notes</div>";
		include('./div/matchSummaryDiv.php');
		echo "<div class=\"sectionPage\">";
		echo "<form method=\"POST\" action=\"index.php\">";
		echo "<p><b>ATTENTION !</b> Le site de Whoscored vient de changer. L'adresse à entrer pour l'import des données est légèrement différente. Il faut écrire LiveOld à la place de Live à la fin :</p>";
		echo "<p><b>http://www.whoscored.com/Matches/716983/LiveOld</b></p>";
		echo "<p>Adresse du compte rendu du match sur le site WS : <input type=\"text\" name=\"pageurl\" size=\"50\"/></p>";
		echo "<input type=\"hidden\" name=\"page\" value=\"parsewhoscored\"/>";
		$matchId = intval($_GET['matchId']);
		echo "<input type=\"hidden\" name=\"matchId\" value=\"{$matchId}\"/>";
		echo "<input type=\"submit\" value=\"Importer\"/>";
		echo "</form></div>";
		echo "<div class='hr_feinte3'></div>";
		include('./div/enterNotesDiv.php');
	}
?>