<?php
include('../../../process/checkAccess.php');
checkAccess(5);
include("../../../includes/db.php");
include('../../../process/validateForm.php');

$journeeId = correctSlash($_POST['journee']);

// Principe : la moyenne des 3 journées précedentes détermine si on monte ou si on descend de classe.
$getJourneesId = $db->getArray("select distinct jjs_journee_id from km_join_joueur_salaire inner join journee j on j.id = jjs_journee_id where j.date <= ( select j2.date from journee j2 where j2.id={$journeeId}) order by j.date desc limit 3");
$getClasses = $db->getArray("select scl_id,scl_salaire,scl_seuil_inf,scl_seuil_sup,scl_next_down,scl_next_up from km_const_salaire_classe");
$classesMap = array();
foreach ($getClasses as $value) {
	$classesMap[$value['scl_id']] = $value;
}

$noChange=0;
$inJ='';
if ($getJourneesId == NULL || sizeof($getJourneesId) < 3) { 
	// Pas assez de journées : on ne change pas le niveau de salaire.
	$noChange=1;
	$previousJ = 0;
} else {
	$previousJ = $getJourneesId[1][0];
	$inJ='('.$getJourneesId[0][0].','.$getJourneesId[1][0].','.$getJourneesId[2][0].')';
}
if ($noChange) {
	$updateQ = "insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select t.jjs_joueur_id,t.jjs_salaire_classe_id,{$journeeId} from km_join_joueur_salaire t where t.jjs_journee_id={$previousJ} on duplicate key update jjs_salaire_classe_id=t.jjs_salaire_classe_id";
	$db->query($updateQ);
} else {
	$salaires = $db->getArray("select * from km_const_salaire_classe");

	//$joueursQuiOntJoue = "select jpe_joueur_id,jjs_salaire_classe_id from km_joueur_perf inner join km_join_joueur_salaire on jpe_joueur_id=jjs_joueur_id where jpe_match_id in (select m.id from rencontre m where m.journee_id={$journeeId}) and jjs_journee_id={$previousJ}";
	$joueursQuiOntJoueOuPas = "select jjs_joueur_id,jjs_salaire_classe_id from km_join_joueur_salaire where jjs_journee_id={$previousJ}";
	$joueurs = $db->getArray($joueursQuiOntJoueOuPas);
	if ($joueurs != NULL) {
		foreach ($joueurs as $joueur) {
			// Moyenne des scores des trois dernières journées
			$scoresQ = "select sum(jpe_score)/3 from km_joueur_perf where jpe_joueur_id={$joueur['jjs_joueur_id']} and jpe_match_id in (select re.id from rencontre re where re.journee_id in {$inJ})";
			$scoreRes = $db->getArray($scoresQ);
			$classe = $classesMap[$joueur['jjs_salaire_classe_id']];
			if ($scoreRes [0][0] == NULL) {
				$newId = $classe['scl_next_down'];
			} else {
				if ($scoreRes[0][0] < $classe['scl_seuil_inf']) {
					$newId = $classe['scl_next_down'];
				} else if ($scoreRes[0][0] > $classe['scl_seuil_sup']) {
					$newId = $classe['scl_next_up'];
				} else {
					$newId = $classe['scl_id'];
				}
			}
			$updateQ = "insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) values ({$joueur['jjs_joueur_id']},{$newId},{$journeeId}) on duplicate key update jjs_salaire_classe_id={$newId}";
			$db->query($updateQ);
		}
	}
}

header('Location: ../index.php');
exit();

// Requete de vérification:
// SELECT jjs_joueur_id,prenom,nom,jjs_salaire_classe_id,jjs_journee_id,jpe_score FROM `km_join_joueur_salaire` inner join joueur on jjs_joueur_id=id left outer join km_joueur_perf on jjs_joueur_id=jpe_joueur_id and jpe_match_id in (select re.id from rencontre re where re.journee_id=jjs_journee_id) WHERE jjs_joueur_id=917

// SELECT j.prenom, j.nom, j.score2, jjs_salaire_classe_id from joueur j inner join km_join_joueur_salaire on j.id=jjs_joueur_id where jjs_journee_id=39 order by jjs_salaire_classe_id desc
?>