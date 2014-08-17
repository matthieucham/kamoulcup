<?php
include("../includes/db.php");
include("generatePassword.php");
$utilisateurCreer = $_POST['nom'];
if (!get_magic_quotes_gpc()) {
    $utilisateurCreer = addslashes($_POST['nom']);
} 
$checkExistQuery = "select id from utilisateur where nom= '{$utilisateurCreer}' limit 1";
if ($db->getArray($checkExistQuery) == NULL) {
	// Pas d'utilisateur portant ce nom : on peut le créer
	$password=generatePassword(6,0);
	$insertQuery = "insert into utilisateur(nom,password,droit) values('{$utilisateurCreer}',MD5('{$password}'),'{$_POST['droit']}')";
	$db->query($insertQuery) or die('Error, insert query failed, see log');

} else {
	// erreur
	$errorMsg='cet utilisateur existe déjà';
	$password='';
}
header('Location: index.php?errorMsg='.$errorMsg.'&password='.$password);
exit();

?>