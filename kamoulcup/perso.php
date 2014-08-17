<?php
	checkAccess(1);
?>
<div class='titre_page'><?php echo "{$_SESSION['username']}";?></div>

<div class="sous_titre">Paramètres personnels</div>
<ul>
	<li>» <a href='index.php?page=editPassword'>Changer de mot de passe</a></li>
</ul>
<?php
if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>