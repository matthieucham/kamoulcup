<?php

function calculDateFinEnchere($dateDebut,$nbHeures){
	global $db;
	$skipWEQuery = $db->getArray("select valeur from parametres where cle='skip_we'");
	$skipWE = intval($skipWEQuery[0][0]);
	$endTime = $dateDebut;
	$startDateDay = date('w',$endTime);
	$startDateH = date('G',$endTime);
	$startDateM = date('i',$endTime);
	$startDateS = date('s',$endTime);

	if ($skipWE==0) {
		if ($startDateDay == 0) {
			// Début d'enchères un Dimanche : on se replace à 12h le lendemain même.
			$endTime -= ($startDateH*3600 + $startDateM*60 + $startDateS);
			$endTime += 36*3600;
		}
		if ($startDateDay == 6) {
			// Début d'enchères un Samedi : on se replace à 12h le surlendemain
			$endTime -= ($startDateH*3600 + $startDateM*60 + $startDateS);
			$endTime += 59*3600;
		}
	}

	// Ajout du délai syndical
	$endTime+=(3600*$nbHeures);
	$endDateDay = date('w',$endTime);

	if ($skipWE==0) {
		if ($endDateDay == 0 || $endDateDay == 6) {
			// Fin d'enchères un Dimanche ou un samedi: on rajoute 48h
			$endTime += 48*3600;
		}
	}

	// On ajuste l'heure de fin à midi ou 19h le jour pr�vu.
	$endDateH = date('G',$endTime);
	$endDateM = date('i',$endTime);
	$endDateS = date('s',$endTime);

	if ($endDateH < 12) {
		// avant midi : on déplace la fin à midi
		$endTime -= ($endDateH*3600 + $endDateM*60 + $endDateS);
		$endTime += 12*3600;
	} else if ($endDateH < 19) {
		// avant 19h : on déplace la fin à 19h
		$endTime -= ($endDateH*3600 + $endDateM*60 + $endDateS);
		$endTime += 19*3600;
	} else {
		// après 19h : on déplace la fin à 12h le lendemain
		$endTime -= ($endDateH*3600 + $endDateM*60 + $endDateS);
		$endTime += 36*3600;
		if ($skipWE == 0) {
			// Si ça nous fait tomber à samedi midi, déplacer au lundi midi.
			$endDateDay = date('w',$endTime);
			if ($endDateDay == 6) {
				$endTime += 48*3600;
			}
		}
	}
	return $endTime;
}


?>