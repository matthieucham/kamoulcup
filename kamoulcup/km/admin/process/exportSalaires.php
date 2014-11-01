<?php
include('../../../process/checkAccess.php');
checkAccess(5);
include("../../../includes/db.php");

$req = "SELECT prenom,nom,jjs_salaire_classe_id FROM joueur inner join`km_join_joueur_salaire` on jjs_joueur_id=id where jjs_journee_id=0 order by jjs_salaire_classe_id desc";

$lignes=$db->getArray($req);

echo "<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
</head><body>";

foreach($lignes as $ligne) {
    echo "<p>insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,{$ligne['jjs_salaire_classe_id']},0 from joueur where prenom='{$ligne['prenom']}' and nom='{$ligne['nom']}' on duplicate key update jjs_salaire_classe_id={$ligne['jjs_salaire_classe_id']};</p>";
}

echo "</body></html>";

?>