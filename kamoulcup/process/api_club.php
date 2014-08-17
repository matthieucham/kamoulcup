<?php
	function listClubs() {
		global $db;
		$query = "select id,nom,id_lequipe from club order by nom asc";
		return $db->getArray($query);
	}
?>