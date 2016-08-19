<?php

// Conversion note à l'allemande (6 -> 1) vers note 0 -> 10
function convertNoteKicker($note) {
	$noteConvertie = (1-(floatval($note)/8))*10;
	return $noteConvertie;
}

function convertNoteWS($note) {
	$a= -0.5327483;
	$b= 2.409241;
	$c= 122.5656;
	$d= 254.007;

	$y = round(round(($d+($a-$d)/(1+pow(10*$note/$c, $b)))/5)/2,1);

	return $y;
}

function formatNote($note) {
	$f = round($note,1);
	if ($f > 0){
		return ''.$f;
	}
	return '';
}

?>