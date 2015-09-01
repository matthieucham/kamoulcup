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
		$createJoueurQ = "insert into joueur(prenom,nom,uuid,club_id) select '{$fn}', '{$ln}', '{$uuid}', '{$clubId}'";
		$db->query($createJoueurQ);
		$getJoueur = $db->getArray("select id,poste from joueur where uuid='{$uuid}'");
	} else {
		// Update club_id si club différent
		$oldcl = $getJoueur[0][2];
		if ($oldcl != $clubId) {
			$updateJoueurQ = "update joueur set club_id={$clubId} where uuid='{$uuid}'";
			$db->query($updateJoueurQ);
		}
	}
}

header('Location: ../index.php?page=postImport');
exit();

?>