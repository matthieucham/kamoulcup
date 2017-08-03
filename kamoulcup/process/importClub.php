<?php
include('checkAccess.php');
checkAccess(2);
include("../includes/db.php");
include('params/statnutsParams.php');
include('params/notationParams.php');
include('api_import.php');

$uuidclub = $_POST['clubuuid'];
$clubId = $_POST['clubid'];

$token = getAccessToken();
$clObj = getClubWithMembers($token, $uuidclub);
// Parcours des membres de l'effectif
for($i=0; $i < count($clObj->members); $i++) {
	$current = $clObj->members[$i];
	$uuid = $current->uuid;

	$getJoueur = $db->getArray("select id, poste, club_id from joueur where uuid='{$uuid}'");
	if ($getJoueur == NULL) {
		// Création du joueur.
		if (property_exists($current, 'usual_name') && strlen($current->usual_name)>0) {
			$fn = NULL;
			$ln =  htmlspecialchars($current->usual_name, ENT_COMPAT, 'UTF-8');
		} else {
			if (property_exists($current, 'first_name')) {
				$fn = htmlspecialchars($current->first_name, ENT_COMPAT, 'UTF-8');
			} else {
				$fn = NULL;
			}
			$ln =  htmlspecialchars($current->last_name, ENT_COMPAT, 'UTF-8');
		}
		$fn = mysql_escape_string($fn);
		$ln = mysql_escape_string($ln);
		$pos = $current->position;
		$createJoueurQ = "insert into joueur(prenom,nom,uuid,club_id,poste) select '{$fn}', '{$ln}', '{$uuid}', id, '{$pos}' from club where uuid='{$current->played_for}'";
		$db->query($createJoueurQ);
	} else {
		// Update club_id si club différent
		$oldcl = $getJoueur[0][2];
		if ($oldcl != $clubId) {
			$updateJoueurQ = "update joueur set club_id={$clubId} where uuid='{$uuid}'";
			$db->query($updateJoueurQ);
		}
		$oldPos = $getJoueur[0][1];
		$pos = $current->position;
		if ($oldPos != $pos) {
			$updateJoueurQ = "update joueur set poste={$pos} where uuid='{$uuid}'";
			$db->query($updateJoueurQ);
			$joueurPoste = $pos;
		}
	}
}

header('Location: ../index.php?page=postImport');
exit();

?>