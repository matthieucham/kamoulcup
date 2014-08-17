<?php
	checkAccess(1);
	
	$getURLQuery=$db->getArray("select logo from ekyp where id='{$_SESSION['myEkypId']}' limit 1");
	$logoURL='';
	if ($getURLQuery != NULL) {
		$logoURL=$getURLQuery[0][0];
	}
?>
<div class="formDiv">
	<div class='titre_page'>Edition du logo de l'ekyp</div>
	<form method="POST" action="process/saveLogo.php">
	<p>Entrez l'url d'une image de moins de 150px de largeur.</p>
	<p>Utilisez par exemple <a href="http://photobucket.com/">Photobucket</a> pour l'héberger</p>
	<br/>
	<table class="tableau_saisie">
		<tbody>
			<tr>
				<td><input type="text" size="90" name="logo" value="<?php echo $logoURL; ?>"/></td>
			</tr>
		</tbody>
	</table>
	<p><input type="submit" value="Sauver"/></p>
</div>