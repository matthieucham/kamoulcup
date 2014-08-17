<?php
function createResolutionEntry($resolutionId) {
	// récup des données
	global $db;
	$requete = "select jo.prenom,jo.nom as nomJoueur,jo.poste,ve.auteur_id,ve.type,ve.montant as montantPa,ek.nom as nomEkypVainqueur,date_format(ve.date_soumission,'%d/%m %H:%i:%s') as dateDeb,date_format(ve.date_finencheres,'%d/%m %H:%i:%s') as dateFin,res.id,res.montant_gagnant,res.reserve,res.annulee,ve.poule_id,en.montant,en.exclue,cl.nom as nomClub from vente as ve,resolution as res,enchere as en,ekyp as ek,joueur as jo,club as cl where res.vente_id=ve.id and ve.resolue=1 and ve.joueur_id=jo.id and res.gagnant_id=ek.id and en.vente_id=ve.id and jo.club_id=cl.id and res.id={$resolutionId} order by en.montant desc";
	$getResolutionQuery = $db->getArray($requete);
	if ($getResolutionQuery != NULL) {
		$type = $getResolutionQuery[0]['type'];
		$auteurId = $getResolutionQuery[0]['auteur_id'];
		$nomAuteur = $db->getArray("select nom from ekyp where id={$auteurId}");
		$auteur = $nomAuteur[0][0];
		// Fabrication du fragment XML du feed.
		/* create a dom document with encoding utf8 */
		$implementation = new DOMImplementation();
		$dtd = $implementation->createDocumentType('html',
		'-//W3C//DTD XHTML 1.1//EN','http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd');
		$domtree = $implementation->createDocument('','',$dtd);//new DOMDocument('1.0', 'UTF-8');
		/* create the root element of the xml tree */
		$xmlRoot = $domtree->createElement("resolution");
		/* append it to the document created */
		$xmlRoot = $domtree->appendChild($xmlRoot);
		$resolIdAttr = $xmlRoot->setAttribute('id',$getResolutionQuery[0]['id']);
		$resolTypeAttr = $xmlRoot->setAttribute('type',$getResolutionQuery[0]['type']);
		$xmlRoot->appendChild($domtree->createElement("poule",$getResolutionQuery[0]['poule_id']));
		$joueurNode = $xmlRoot->appendChild($domtree->createElement("joueur"));
		$joueurNode->appendChild($domtree->createElement("prenom",$getResolutionQuery[0]['prenom']));
		$joueurNode->appendChild($domtree->createElement("nom",$getResolutionQuery[0]['nomJoueur']));
		$joueurNode->appendChild($domtree->createElement("poste",$getResolutionQuery[0]['poste']));
		$joueurNode->appendChild($domtree->createElement("club",$getResolutionQuery[0]['nomClub']));
		if ($type == 'PA') {
			$paNode = $xmlRoot->appendChild($domtree->createElement("pa"));
			$paNode->appendChild($domtree->createElement("ekyp",$auteur));
			$paNode->appendChild($domtree->createElement("montant",number_format(floatval($getResolutionQuery[0]['montantPa']),1)));
		} elseif ($type == 'MV') {
			$mvNode = $xmlRoot->appendChild($domtree->createElement("mv"));
			$mvNode->appendChild($domtree->createElement("ekyp",$auteur));
			$mvNode->appendChild($domtree->createElement("montant",number_format(floatval($getResolutionQuery[0]['montantPa']),1)));
		} elseif ($type == 'RE') {
			$reNode = $xmlRoot->appendChild($domtree->createElement("re"));
			$reNode->appendChild($domtree->createElement("ekyp",$auteur));
			$reNode->appendChild($domtree->createElement("montant",number_format(floatval($getResolutionQuery[0]['montantPa']),1)));
		}
		$resultatNode = $xmlRoot->appendChild($domtree->createElement("resultat"));
		$resultatNode->setAttribute("reservePasAtteint",$getResolutionQuery[0]['reserve']);
		$resultatNode->setAttribute("pasDOffre",$getResolutionQuery[0]['annulee']);
		$resultatNode->appendChild($domtree->createElement("ekyp",$getResolutionQuery[0]['nomEkypVainqueur']));
		$resultatNode->appendChild($domtree->createElement("montant",number_format(floatval($getResolutionQuery[0]['montant_gagnant']),1)));
		if ($type != RE) {
			$offresNode = $xmlRoot->appendChild($domtree->createElement("offres"));
			foreach ($getResolutionQuery as $offre) {
				$offreNode = $offresNode->appendChild($domtree->createElement("offre"));
				$offreNode->setAttribute("montant",number_format(floatval($offre['montant']),1));
				$offreNode->setAttribute("exclue",$offre['exclue']);
			}
		}

		/* get the xml printed */
		//echo $domtree->saveXML();
		// Enregistrement en BD
		$xmlData = htmlspecialchars($domtree->saveXML(),ENT_QUOTES,"UTF-8");
		$db->query("insert into feed_resolutions(date_enregistrement,resolution_id,xml) values (now(),{$getResolutionQuery[0]['id']},'{$xmlData}') on duplicate key update date_enregistrement=now(),xml='{$xmlData}',updatee=1");
	}
}
?>