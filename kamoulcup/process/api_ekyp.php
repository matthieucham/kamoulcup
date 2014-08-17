<?php
function ekyp_getTactique($ekypId) {
	global $db;
	return $db->getArray("select ta.nb_g, ta.nb_d, ta.nb_m, ta.nb_a from tactique as ta, ekyp as ek where ek.id={$ekypId} and ek.tactique_id=ta.id limit 1");
}
?>