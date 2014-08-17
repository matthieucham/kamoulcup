<?php
include('JSON.php');
include('../includes/db.php');
include ('../process/params/notationParams.php');


class Joueur {
	var $prenom;
	var $nom;
	var $joueurDbId;
	var $clubId;
	var $score;
	var $nbNotes;
	var $poste;
}

class Ekyp {
	var $gardiens;
	var $defenseurs;
	var $milieux;
	var $attaquants;
}

//function htmlspecialchars_decode($chaineHtml) {
//    $tmp = get_html_translation_table(HTML_ENTITIES);
//    $tmp = array_flip ($tmp);
//    $chaineTmp = strtr ($chaineHtml, $tmp);
//    return $chaineTmp;
//}


function toJoueursJSON($dbArray) {
	global $db;
	global $SCO_minTps;
	$out = Array();
	if ($dbArray != NULL) {
		foreach($dbArray as $g) {
			$jsonG = new Joueur();
			$jsonG->joueurDbId = $g['id'];
			if ($g['club_id'] != NULL) {
				$getClubId = $db->getArray("select id_lequipe from club where id={$g['club_id']} limit 1");	
				$jsonG->clubId = $getClubId[0][0];
			} else {
				$jsonG->clubId='noclub';
			}
			$jsonG->score = number_format(round($g['scoreBonif'],2),2);
			$countNotes = $db->getArray("select count(*) from prestation where joueur_id={$g['id']} and score>0 and minutes>={$SCO_minTps}");	
			$jsonG->nbNotes = $countNotes[0][0];
			$jsonG->poste = $g['poste'];
			$jsonG->prenom = (htmlspecialchars_decode($g['prenom']));
			$jsonG->nom = (htmlspecialchars_decode($g['nom']));
			array_push ($out,$jsonG);
		}
	}
return $out;
}

$ekypId = $_GET['ekypid'];

// Requ�te
$getTactiqueQuery = $db->getArray("select ta.nb_g, ta.nb_d, ta.nb_m, ta.nb_a from tactique as ta, ekyp as ek where ek.id='{$ekypId}' and ek.tactique_id=ta.id limit 1");
$listGardiensQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, (jo.score*tr.coeff_bonus_achat) as scoreBonif,jo.id_lequipe,jo.club_id from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='G' order by scoreBonif desc limit {$getTactiqueQuery[0]['nb_g']}");
$listDefenseursQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, (jo.score*tr.coeff_bonus_achat) as scoreBonif,jo.id_lequipe,jo.club_id from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='D' order by scoreBonif desc limit {$getTactiqueQuery[0]['nb_d']}");
$listMilieuxQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, (jo.score*tr.coeff_bonus_achat) as scoreBonif,jo.id_lequipe,jo.club_id from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='M' order by scoreBonif desc limit {$getTactiqueQuery[0]['nb_m']}");
$listAttaquantsQuery = $db->getArray("select jo.id, jo.prenom, jo.nom, jo.poste, (jo.score*tr.coeff_bonus_achat) as scoreBonif,jo.id_lequipe,jo.club_id from joueur as jo, transfert as tr where tr.joueur_id=jo.id and tr.ekyp_id={$ekypId} and jo.poste='A' order by scoreBonif desc limit {$getTactiqueQuery[0]['nb_a']}");


//$titulaires = array($gardiens,$defenseurs,$milieux,$attaquants);
$titulaires = new Ekyp();
$titulaires->gardiens = toJoueursJSON($listGardiensQuery);
$titulaires->defenseurs = toJoueursJSON($listDefenseursQuery);
$titulaires->milieux = toJoueursJSON($listMilieuxQuery);
$titulaires->attaquants = toJoueursJSON($listAttaquantsQuery);
$sJSON = new Services_JSON();
echo $sJSON->encode($titulaires);

?>