<?php
include ('params/notationParams.php');

/**
 * Calcule le score d'un joueur selon une nouvelle méthode : score journée par journée
 * Enter description here ...
 * @param $joueurId
 */
function calculScoreJoueur2($db,$joueurId){
	global $SCO_nbperfs;
	global $SCO_minTps;
	global $SCO_tpsEntreeCourte;
	global $NOT_defvierge;
	global $NOT_defunpenalty;
	global $NOT_defunbut;
	global $NOT_but;
	global $NOT_penalty;
	global $NOT_passedec;
	global $NOT_penaltyobtenu;
	global $NOT_troisbuts;
	global $NOT_troisbutsunpenalty;
	global $SCO_noteEC;
	global $SCO_noteEL;
	global $SCO_journeePivot;
	global $SCO_nbperfs1;
	global $SCO_nbperfs2;
	global $NOT_leader;
	global $NOT_arret;
	global $NOT_encaisse;

	$bestNotes = Array();
	$bestNotes1 = Array();
	$bestNotes2 = Array();
	$nbEntreesCourtes=0;
	$nbEntreesLongues=0;
	$nbEntreesCourtes1=0;
	$nbEntreesLongues1=0;
	$nbEntreesCourtes2=0;
	$nbEntreesLongues2=0;

	$query="select jo.numero,jo.id as idJournee,j.poste,p.score,p.minutes,p.but_marque,p.passe_dec,p.penalty_marque,p.penalty_obtenu,p.defense_vierge,p.defense_unpenalty,p.defense_unbut,p.troisbuts,p.troisbuts_unpenalty,p.double_bonus,p.leader,p.arrets,p.encaisses from prestation as p, journee as jo, rencontre as re, joueur as j where p.joueur_id={$joueurId} and p.match_id=re.id and re.journee_id=jo.id and p.joueur_id=j.id order by jo.numero asc";
	$prestations = $db->getArray($query);
	$exceptionnelQuery = $db->getArray("select sum(valeur) as total from bonus_joueur where joueur_id={$joueurId}");
	$bonusSoFar = 0;
	$bonusSoFar1=0;
	$bonusSoFar2=0;
	$journeesIdsWithPresta = Array();
	$storedScores = Array();
	$storedScores1 = Array();
	$storedScores2 = Array();
	if ($prestations != NULL) {
		foreach($prestations as $presta) {
			$prestaNote = 0;
			$joueurPoste = $presta['poste'];
			if (intval($presta['minutes']) >= $SCO_minTps && floatval($presta['score']) > 0)
			{
				//Une nouvelle note
				$prestaNote = floatval($presta['score']);
				// Si on n'en avait pas déjà assez, on l'ajoute de toute façon
				if(count($bestNotes) < $SCO_nbperfs) {
					$bestNotes[]=$prestaNote;
					sort($bestNotes);
				} else {
					// on a déjà le nombre voulu de notes : si c'est une note supérieure au minimum, on la compte, sinon non.
					$minNote = $bestNotes[0];
					if ($minNote < $prestaNote) {
						$bestNotes[0] = $prestaNote;
						sort($bestNotes);
					}
				}
				if (intval($presta['numero']) < $SCO_journeePivot) {
					// A prendre en compte pour le score1
					if(count($bestNotes1) < $SCO_nbperfs1) {
						$bestNotes1[]=$prestaNote;
						sort($bestNotes1);
					} else {
						// on a déjà le nombre voulu de notes : si c'est une note supérieure au minimum, on la compte, sinon non.
						$minNote = $bestNotes1[0];
						if ($minNote < $prestaNote) {
							$bestNotes1[0] = $prestaNote;
							sort($bestNotes1);
						}
					}
				} else {
					// A prendre en compte pour le score2
					if(count($bestNotes2) < $SCO_nbperfs2) {
						$bestNotes2[]=$prestaNote;
						sort($bestNotes2);
					} else {
						// on a déjà le nombre voulu de notes : si c'est une note supérieure au minimum, on la compte, sinon non.
						$minNote = $bestNotes2[0];
						if ($minNote < $prestaNote) {
							$bestNotes2[0] = $prestaNote;
							sort($bestNotes2);
						}
					}
				}
			} else if (intval($presta['minutes']) < $SCO_tpsEntreeCourte) {
				$nbEntreesCourtes++;
				if (intval($presta['numero']) < $SCO_journeePivot) {
					$nbEntreesCourtes1++;
				} else {
					$nbEntreesCourtes2++;
				}
			} else {
				$nbEntreesLongues++;
				if (intval($presta['numero']) < $SCO_journeePivot) {
					$nbEntreesLongues1++;
				} else {
					$nbEntreesLongues2++;
				}
			}
			// on calcule ici la partie du score dépendante des notes.
			$partieNotes=array_sum($bestNotes);
			$partieNotes1=array_sum($bestNotes1);
			$partieNotes2=array_sum($bestNotes2);
			if (count($bestNotes) < $SCO_nbperfs) {
				$nombreManquants = $SCO_nbperfs-count($bestNotes);
				if ($nbEntreesLongues >= $nombreManquants)
				{
					$partieNotes += ($nombreManquants*$SCO_noteEL);
				} else {
					$nombreManquants -= $nbEntreesLongues;
					$partieNotes += ($nbEntreesLongues*$SCO_noteEL);
					$partieNotes += $SCO_noteEC*(min($nombreManquants,$nbEntreesCourtes));
				}
			}
			if (count($bestNotes1) < $SCO_nbperfs1) {
				$nombreManquants = $SCO_nbperfs1-count($bestNotes1);
				if ($nbEntreesLongues1 >= $nombreManquants)
				{
					$partieNotes1 += ($nombreManquants*$SCO_noteEL);
				} else {
					$nombreManquants -= $nbEntreesLongues1;
					$partieNotes1 += ($nbEntreesLongues1*$SCO_noteEL);
					$partieNotes1 += $SCO_noteEC*(min($nombreManquants,$nbEntreesCourtes1));
				}
			}
			if (count($bestNotes2) < $SCO_nbperfs2) {
				$nombreManquants = $SCO_nbperfs2-count($bestNotes2);
				if ($nbEntreesLongues2 >= $nombreManquants)
				{
					$partieNotes2 += ($nombreManquants*$SCO_noteEL);
				} else {
					$nombreManquants -= $nbEntreesLongues2;
					$partieNotes2 += ($nbEntreesLongues2*$SCO_noteEL);
					$partieNotes2 += $SCO_noteEC*(min($nombreManquants,$nbEntreesCourtes2));
				}
			}

			$partieBonus=0;
			$partieBonus1=0;
			$partieBonus2=0;
			$partieBonus+=$NOT_but*intval($presta['but_marque']);
			$partieBonus+=$NOT_passedec*intval($presta['passe_dec']);
			$partieBonus+=$NOT_penalty*intval($presta['penalty_marque']);
			$partieBonus+=$NOT_penaltyobtenu*intval($presta['penalty_obtenu']);
			$partieBonus+=$NOT_defvierge[$joueurPoste]*intval($presta['defense_vierge']);
			$partieBonus+=$NOT_defunpenalty[$joueurPoste]*intval($presta['defense_unpenalty']);
			$partieBonus+=$NOT_defunbut[$joueurPoste]*intval($presta['defense_unbut']);
			$partieBonus+=$NOT_troisbuts[$joueurPoste]*intval($presta['troisbuts']);
			$partieBonus+=$NOT_troisbutsunpenalty[$joueurPoste]*intval($presta['troisbuts_unpenalty']);
			$partieBonus+=$NOT_leader[$joueurPoste]*intval($presta['leader']);
			$partieBonus+=$NOT_arret[$joueurPoste]*intval($presta['arrets']);
			$partieBonus+=$NOT_encaisse[$joueurPoste]*intval($presta['encaisses']);

			if (intval($presta['double_bonus'])){
				$partieBonus *= 2;
			}
			if (intval($presta['numero']) < $SCO_journeePivot) {
				$partieBonus1 = $partieBonus;
			} else {
				$partieBonus2 = $partieBonus;
			}
			$scoreSoFar = $partieNotes + $partieBonus + $bonusSoFar;
			$scoreSoFar1 = $partieNotes1 + $partieBonus1 + $bonusSoFar1;
			$scoreSoFar2 = $partieNotes2 + $partieBonus2 + $bonusSoFar2;
			// insertion des stats
			storeStatJoueur($db, $scoreSoFar, $scoreSoFar1, $scoreSoFar2,$joueurId,$presta['idJournee']);
			$storedScores[$presta['idJournee']] = $scoreSoFar;
			$storedScores1[$presta['idJournee']] = $scoreSoFar1;
			$storedScores2[$presta['idJournee']] = $scoreSoFar2;
			$bonusSoFar += $partieBonus;
			$bonusSoFar1 += $partieBonus1;
			$bonusSoFar2 += $partieBonus2;
			// Empile par ordre de numéro
			$journeesIdsWithPresta[] = $presta['idJournee'];
		}
	}
	// Remplir les trous
	$allJournees = journee_list();
	if ($allJournees != NULL) {
		$lastScore=0;
		$lastScore1=0;
		$lastScore2=0;
		foreach($allJournees as $journee)
		{
			if (! in_array($journee['id'],$journeesIdsWithPresta))
			{
				storeStatJoueur($db, $lastScore,$lastScore1,$lastScore2,$joueurId,$journee['id']);
			} else {
				$lastScore = $storedScores[$journee['id']];
				$lastScore1 = $storedScores1[$journee['id']];
				$lastScore2 = $storedScores2[$journee['id']];
			}
		}
	}

	// bonus spéciaux
	if ($exceptionnelQuery != NULL) {
		$scoreSoFar += $exceptionnelQuery[0][0];
	}

	$db->query("update joueur set score={$scoreSoFar}, score1={$scoreSoFar1}, score2={$scoreSoFar2} where id={$joueurId} limit 1");

	return $scoreSoFar;
}

function calculScorePrestation($db,$prestationId) {
	$getPrestationQuery = $db->getArray("select pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e from prestation as pr where (pr.id='{$prestationId}') limit 1");
	$noteLE = $getPrestationQuery[0]['note_lequipe'];
	$noteFF = $getPrestationQuery[0]['note_ff'];
	$noteSP = $getPrestationQuery[0]['note_sp'];
	$noteD = $getPrestationQuery[0]['note_d'];
	$noteE = $getPrestationQuery[0]['note_e'];
	$compteurNote =0;
	$note =0;
	if ($noteLE != NULL) {
		$compteurNote++;
		$note += $noteLE;
	}
	if ($noteFF != NULL) {
		$compteurNote++;
		// noteFF est une note "à l'allemande": il faut la convertir.
		//$noteConvertie = (1-(floatval($noteFF)/8))*10;
		//$note += $noteConvertie;
		$note += $noteFF;
	}
	if ($noteSP != NULL) {
		$compteurNote++;
		$note += $noteSP;
	}
	if ($noteD != NULL) {
		$compteurNote++;
		$note += $noteD;
	}
	if ($noteE != NULL) {
		$compteurNote++;
		$note += $noteE;
	}
	if ($compteurNote > 0) {
		$note /= $compteurNote;
	}
	//echo $note; echo ' '; echo $compteurNote;
	$db->updateTable('prestation','score',$note,$prestationId);
}
?>