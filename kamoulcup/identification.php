<div class="sectionPage">
<div class='titre_page'>Identification</div>
<div>
 <form method="POST" action="process/identifyUser.php">
		<table class="tableau_saisie">
			<tr>
				<th>Nom: </th>
				<td><input type="text" size="32" name="nom" /></td>
			</tr>
			<tr>
				<th>Mot de passe: </th>
				<td><input type="password" size="32" name="password" /></td>
			</tr>
		</table>
		<input type="submit" value="S'identifier"/>
	</form>
</div>
<?php if(isset($_GET['errorMsg'])){
	echo "<div class='error'>";
	echo $_GET['errorMsg'];
	echo "</div>";}
	?></div>
