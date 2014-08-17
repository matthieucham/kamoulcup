<?php
function transfert_listTransfertsDraft($pouleId) {
	global $db;
	$query = "select jo.id as idJoueur, jo.prenom, jo.nom as nomJoueur, tr.choix_draft, ek.nom as nomEkyp, ek.id as idEkyp, ek.draft_order from joueur jo, ekyp ek, transfert tr where tr.draft=1 and tr.joueur_id=jo.id and tr.ekyp_id=ek.id and tr.poule_id={$pouleId} order by ek.draft_order asc";
	$draft = $db->getArray($query);
	return $draft;
}

function transfert_listTransferts($ekypId) {
	global $db;
	$query = "select joueur_id,transfert_date,coeff_bonus_achat,j.score,j.score1,j.score2,j.poste from transfert,joueur j where ekyp_id={$ekypId} and joueur_id=j.id";
	return $db->getArray($query);
}

function transfert_listJoueursAtDate($ekypId,$date) {
	global $db;
	$query= "select jo.id,jo.poste,tr.coeff_bonus_achat from transfert tr, joueur jo where tr.joueur_id=jo.id and unix_timestamp(tr.transfert_date)<{$date} and tr.ekyp_id={$ekypId} order by field(jo.poste,'G','D','M','A')";
	return $db->getArray($query);
}
?>