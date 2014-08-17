<?php
include("../includes/db.php");
// Appelé par le robot online-cron

function PostToHost($host, $path, $data_to_send) {
	$errno = 0;
	$errstr = '';
	$fp = fsockopen($host,80,$errno,$errstr);
	//echo "### ERROR: {$errstr} ###<br/>";
	fputs($fp, "POST $path HTTP/1.1\n" );
	fputs($fp, "Host: $host\n" );
	fputs($fp, "Content-type: application/x-www-form-urlencoded\n" );
	fputs($fp, "Content-length: ".strlen($data_to_send)."\n" );
	fputs($fp, "Connection: close\n\n" );
	fputs($fp, $data_to_send);
	fclose($fp);
	//echo "SENT !";
}

// Accès autorisé
session_start();
$_SESSION['userrights'] = 4;
// Récupération du numéro de session à résoudre le plus récent
//$getSessionQuery = $db->getArray("select id from session where date_resolution < now() order by date_resolution desc limit 1");
//$sessionId = $getSessionQuery[0][0];
//$listSessionsVenteQuery = $db->getArray("select ve.id, ve.type,ve.resolue,ve.departage_attente from vente as ve where ve.session_id='{$sessionId}' and (ve.type='PA' or ve.type='MV') order by ve.date_soumission asc");

//$aResoudreCount = 0;
//$dataBuf= '';
//foreach($listSessionsVenteQuery as $vente) {
//	if (! ($vente['resolue'])) {
//		$dataBuf .= 'aResoudre['.$aResoudreCount.']='.$vente['id'].'&';
//		$aResoudreCount++;				
//	}				
//}
//echo $sessionId;

echo "Invocation résolution à distance...";
$data = '';
PostToHost("kamoulcup.free.fr","/process/resoudreVentes.php",$data);
session_destroy();

?>