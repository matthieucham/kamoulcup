<?php
include('../includes/db.php');

// On retourne toutes les enchères qui ont moins de 3 jours, et s'il n'y en a pas au moins 20 on complète avec les plus récentes restantes.
$NB_MIN_RESOLUTIONS = 20;
$query1 = "select xml,updatee from feed_resolutions where date_enregistrement > date_sub(now(),interval 3 day) order by date_enregistrement desc";
$feed1 = $db->getArray($query1);
$manquants = 0;
if ($feed != NULL) {
	if (count($feed) < $NB_MIN_RESOLUTIONS) {
		$manquants = $NB_MIN_RESOLUTIONS - count($feed);
	}
} else {
	$manquants = $NB_MIN_RESOLUTIONS;
}
$feed2 = NULL;
if ($manquants >0) {
	$query2 = "select xml,updatee from feed_resolutions where date_enregistrement < date_sub(now(),interval 3 day) order by date_enregistrement desc limit {$manquants}";
	$feed2 = $db->getArray($query2);
}

$xmlResponse = new DOMDocument('1.0', 'UTF-8');
$resolutionsNode = $xmlResponse->createElement('resolutions');
$xmlResponse->appendChild($resolutionsNode);

if ($feed1 != NULL) {
	foreach ($feed1 as $contenu) {
		$implementation = new DOMImplementation();
		$dtd = $implementation->createDocumentType('html',
		'-//W3C//DTD XHTML 1.1//EN','http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd');
		$cdoc = $implementation->createDocument('','',$dtd);
		
		@$cdoc->loadXML(htmlspecialchars_decode($contenu['xml'],ENT_QUOTES));
		// On récupère le résolution contenue à l'intérieur
		$resol = $cdoc->getElementsByTagName('resolution')->item(0);
		if (intval($contenu['updatee'])>0) {
			$resol->setAttribute('update',1);
		}
		$resol = $xmlResponse->importNode($resol, true);
		$resolutionsNode->appendChild($resol);
	}
}
if ($feed2 != NULL) {
	foreach ($feed2 as $contenu) {
		$implementation = new DOMImplementation();
		$dtd = $implementation->createDocumentType('html',
		'-//W3C//DTD XHTML 1.1//EN','http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd');
		$cdoc = $implementation->createDocument('1.0','UTF-8',$dtd);
		@$cdoc->loadXML(htmlspecialchars_decode($contenu['xml'],ENT_QUOTES));
		// On récupère le résolution contenue à l'intérieur
		$resol = $cdoc->getElementsByTagName('resolution')->item(0);
		if (intval($contenu['updatee'])>0) {
			$resol->setAttribute('update',1);
		}
		$resol = $xmlResponse->importNode($resol, true);
		$resolutionsNode->appendChild($resol);
	}
}
// Le XML est retourné comme une brutasse dans la réponse HTTP...
echo $xmlResponse->saveXML();
?>