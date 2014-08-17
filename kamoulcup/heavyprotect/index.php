<?php
include("../includes/db.php");

?>
<html>
<head>
<title>Administration KCup</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="createUserDiv">
<p>Cr�er un utilisateur</p>
<form method="POST" action="createUser.php">
	<table class="inputFormTable">
		<tbody>
			<tr>
				<td class="formCaption">Nom: </td>
				<td><input type="text" size="32" name="nom" /></td>
			</tr>
			<tr>
				<td class="formCaption">Droits: </td>
				<td>
					<select size="1" name="droit">
						<option value='1'>Joueur</option>
						<option value='2'>Noteur</option>
						<option value='3'>Cr�ateur</option>
						<option value='5'>Admin</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<p><input type="submit" value="Cr�er"/></p>
</form>
<p>Modifier le mdp d'un utilisateur</p>
<?php
	$listUserQuery = $db->getArray("select us.nom, us.id from utilisateur as us order by nom asc");
?>
<form method="POST" action="updateUser.php">
	<table class="inputFormTable">
		<tbody>
			<tr>
				<th>Nom: </th>
						<td>
							<select size=1 name="userid">
							<?php
								$listUserQuery = $db->getArray("select us.nom, us.id from utilisateur as us order by nom asc");
								foreach($listUserQuery as $user) {
									echo "<option";
									echo " value='{$user[1]}'>{$user[0]}</option>";
								}
							?>
							</select>
						</td>
			</tr>
			<tr>
			<th>Nouveau mot de passe: </th>
			<td><input type="text" size="32" name="mdp" /></td>
			</tr>
			<tr>
				<td class="formCaption">Droits: </td>
				<td>
					<select size="1" name="droit">
						<option value='1'>Joueur</option>
						<option value='2'>Noteur</option>
						<option value='3'>Cr�ateur</option>
						<option value='5'>Admin</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<p><input type="submit" value="Mettre � jour"/></p>
</form>
<p class="errorMsg">
<?php
    if(isset($_GET['errorMsg'])){
       echo $_GET['errorMsg'];
    }
  ?> 
</p>
<p class="info">
<?php
    if(isset($_GET['password'])){
		if ($_GET['password'] != '') {
			echo 'Mot de passe g�n�r�: <b>'.$_GET['password'].'</b>';
	   }
    }
  ?> 
</p>
</div>
</body>
</html>