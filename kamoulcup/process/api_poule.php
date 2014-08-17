<?php
function poule_listPoules()
{
	global $db;
	$query = "select id, nom, ouverte from poule order by nom asc";
	return $db->getArray($query);
}
?>