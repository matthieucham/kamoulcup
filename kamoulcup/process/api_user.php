<?php

function dirigeEkypDeLaPoule($poule)
{
	return isset($_SESSION['myEkypId']) && isset($_SESSION['pouleId']) && ($_SESSION['pouleId'] == $poule);
}
?>