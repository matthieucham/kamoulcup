<div class='contract_positions_container'>
    <?php
        include_once('../ctrl/franchiseManager.php');
        
        //$sousContrat=getContratsFranchise($_SESSION['myEkypId']);

    function displayPositions($franchiseId) {
        $sousContrat=getContratsFranchise($franchiseId);
        $nbG=0;
        $nbD=0;
        $nbM=0;
        $nbA=0;
				$position = array();
				$position['G']=NULL;
				$position['D1']=NULL;
				$position['D2']=NULL;
				$position['M1']=NULL;
				$position['M2']=NULL;
				$position['A1']=NULL;
				$position['A2']=NULL;
				if ($sousContrat != NULL) { // manière rapide de savoir s'il y a des joueurs dans cette équipe
					foreach ($sousContrat as $contrat) {
						if ($contrat['poste']=='G') {
							if ($position['G']==NULL) {
								$position['G']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbG++;
						}
						if ($contrat['poste']=='D') {
							if ($position['D1']==NULL) {
								$position['D1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['D2']==NULL) {
								$position['D2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbD++;
						}
						if ($contrat['poste']=='M') {
							if ($position['M1']==NULL) {
								$position['M1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['M2']==NULL) {
								$position['M2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbM++;
						}
						if ($contrat['poste']=='A') {
							if ($position['A1']==NULL) {
								$position['A1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['A2']==NULL) {
								$position['A2']=$contrat['prenom'].' '.$contrat['nom'];
							}
                            $nbA++;
						}
					}
				}
				echoPosition($position, 'G', 'G');
				echoPosition($position, 'D', 'D1');
				echoPosition($position, 'D', 'D2');
				echoPosition($position, 'M', 'M1');
				echoPosition($position, 'M', 'M2');
				echoPosition($position, 'A', 'A1');
				echoPosition($position, 'A', 'A2');
    }

function echoPosition($positionArray,$targetPos,$targetSpot) {
		echo "<div class='contract_position'>{$targetPos}<br/>";
		if ($positionArray[$targetSpot] == NULL) {
		 	echo "<i class='fa fa-circle-o'></i>";
		} else {
			echo "<i class='fa fa-circle' title='{$positionArray[$targetSpot]}'></i>";
		}
		echo "</div>";
	}
			?>
		</div>