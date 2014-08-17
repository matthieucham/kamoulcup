<div class="sectionPage">
<div class='titre_page'>Identification</div>
<div><!-- <form method="POST" action="process/identifyUser.php">
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
	</form> -->
<p>Je ne permets plus de faire des opérations sur l'interface Euro2012
pour la Kcup Brasiou, parce que cela provoque des bugs.<a
	href="http://www.kamoulcup.com/kcupbrasiou/index.php?page=identification">Le
login pour la KCup Brasiou est ici</a></p>
</div>
<?php if(isset($_GET['errorMsg'])){
	echo "<div class='error'>";
	echo $_GET['errorMsg'];
	echo "</div>";}
	?></div>
