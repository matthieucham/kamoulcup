<?php
//include('checkAccess.php');
checkAccess(2);
//include("../includes/db.php");
include('process/validateForm.php');

$adresse = $_POST['pageurl'];
$matchId = intval($_POST['matchId']);

if (strlen($adresse)<10) {
	echo "<p>L'adresse indiquée est mauvaise</p>";
	exit(0);
}

// Chargement de la page WS
$curl = curl_init($adresse);

if (! $curl) {
	echo "<p>L'adresse indiquée est mauvaise</p>";
	exit(0);
}

//make content be returned by curl_exec rather than being printed immediately
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);

$tabNotes= extractNotesDiv($result);
//var_dump(json_decode($tabNotes));
//echo $tabNotes;
$loadedTab = json_decode($tabNotes);
if ($loadedTab == NULL) {
	echo "<p>L'adresse indiquée est mauvaise</p>";
	exit(0);
}
$matchData = $loadedTab[0][2];
$domData = $matchData[0][4];
$extData = $matchData[1][4];

//var_dump($loadedTab);

// Parcourir le tableau renvoyé pour en extraire les ids
$wsJoueurIds = array();
foreach ($domData as $domWSJoueur) {
	array_push($wsJoueurIds, $domWSJoueur[0]);
}
$idsDom = join(',',$wsJoueurIds);

$wsJoueurIds = array();
foreach ($extData as $domWSJoueur) {
	array_push($wsJoueurIds, $domWSJoueur[0]);
}
$idsExt = join(',',$wsJoueurIds);

$queryDom = "select jo.id, jo.id_ws, jo.prenom,jo.nom as nomJ,jo.poste,cl.nom as nomC,jo.club_id from joueur jo, club cl, rencontre re where jo.club_id=cl.id and (re.club_dom_id=jo.club_id or jo.id_ws in ({$idsDom})) and re.id={$matchId} order by jo.nom";
$queryExt = "select jo.id, jo.id_ws, jo.prenom,jo.nom as nomJ,jo.poste,cl.nom as nomC,jo.club_id from joueur jo, club cl, rencontre re where jo.club_id=cl.id and (re.club_ext_id=jo.club_id or jo.id_ws in ({$idsExt})) and re.id={$matchId} order by jo.nom";
$joueursEnDbDom = $db->getArray($queryDom);
$joueursEnDbExt = $db->getArray($queryExt);
echo "<form method=\"POST\" action=\"process/saveParsedWhoscored.php\">";
// Présentation du résultat extrait dans un tableau.
echo "<table>
  <tr>
    <th>Joueur WS</th>
    <th>Joueur trouvé en BDD</th>
    <th>Note extraite</th>
  </tr>";

displayContenuTableau($domData,$joueursEnDbDom);
displayContenuTableau($extData,$joueursEnDbExt);
echo "</table>";

echo "<input type=\"hidden\"  name=\"matchid\" value=\"{$matchId}\"/>";
echo "<input type=\"submit\" value=\"Enregistrer\"/>";
echo "</form>";

function displayContenuTableau($wsJoueurs, $dbJoueurs) {
	foreach ($wsJoueurs as $wsJoueur) {
		echo "<tr>";
		$lanote = round(floatval($wsJoueur[2]),1);
		echo "<td>{$wsJoueur[1]}</td>";
		echo "<td><select size=\"1\" name=\"joueurDb[{$wsJoueur[0]}]\" >";
		echo "<option value=\"0\">INCONNU</option>";
		if ($dbJoueurs != NULL) {
			foreach($dbJoueurs as $joueurEnDb) {
				$selected = ($joueurEnDb['id_ws'] != NULL) && ($joueurEnDb['id_ws'] == $wsJoueur[0]);
				echo "<option value=\"{$joueurEnDb['id']}\" ";
				if ($selected) {
					echo "selected ";
				}
				echo ">{$joueurEnDb['prenom']} {$joueurEnDb['nomJ']}</option>";
			}
		}
		echo "</select></td>";
		if ($lanote > 0) {
			echo "<td>{$lanote}<input type=\"hidden\" name=\"noteJoueur[{$wsJoueur[0]}]\" value=\"{$lanote}\"/></td>";
		} else {
			echo "<td>-</td>";
		}
		echo "<input type=\"hidden\" name=\"clubJoueur[{$wsJoueur[0]}]\" value=\"{$joueurEnDb['club_id']}\"/>";
		echo "</tr>";
	}
}

function extractNotesDiv($pageContent) {
	// Extraire la partie de la page qui nous intéresse
	$extraction;
	if (preg_match('/(?:initialMatchDataForScrappers = )(.*);/isU', $pageContent, $matches)) {
		$extraction = $matches[0];
	}
	// outputing all matches for debugging purposes
	//var_dump($matches);
	// Il faut retirer 'initialMatchData = ' au début et le dernier ; à la fin.
	$longueurPrefixe = strlen('initialMatchDataForScrappers = ');
	$longueurSuffixe = strlen(';');
	$inner = substr($extraction, strlen('initialMatchDataForScrappers = '),strlen($extraction)-$longueurPrefixe-$longueurSuffixe);
	// Remplacer les simples quotes en double, pour le JSON.
	$inner=str_replace('\'', '"', $inner);
	// Remplacer les doubles virgules en y insérant un valeur vide
	$inner=str_replace(',,', ',"",', $inner);
	// 2 fois
	$inner=str_replace(',,', ',"",', $inner);
	// Et les fins de tableau ?
	$inner=str_replace(',]', ',""]', $inner);
	// Et les débuts de tableau ?
	$inner=str_replace('[,', '["",', $inner);
	return $inner;
}
?>