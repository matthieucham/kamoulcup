<?php
function journee_list(){
	global $db;
	$query ="select id,numero,date,unix_timestamp(date) as ts from journee order by numero asc";
	return $db->getArray($query);
}

function journee_getLastJourneeBefore($numero){
	global $db;
	$query ="select id,numero,date,unix_timestamp(date) as ts from journee where unix_timestamp(date)<=(select unix_timestamp(jn.date) from journee jn where jn.numero={$numero}) order by date desc limit 1";
	return $db->getArray($query);
}
?>