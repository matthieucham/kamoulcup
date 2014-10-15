<?php
    if (isset($_SESSION['km']) && $_SESSION['km'] ) {
        $franchiseId = $_SESSION['myEkypId'];
    } else {
        echo "Erreur, pas de franchiseId";
        die();
    }

    $merkatoQ="select mer_id from km_mercato where mer_date_ouverture<now() and mer_date_fermeture>now() and mer_processed=0 limit 1";
    $merkato=$db->getArray($merkatoQ);
    if ($merkato != NULL) {
        $merkatoId = $merkato[0][0];
    } else {
        echo "Erreur, pas de mercato en cours";
        die();
    }
    $ekypQ="select nom,fin_solde from ekyp inner join km_finances on fin_ekyp_id=id where id={$franchiseId} order by fin_id desc limit 1";
    $sousContratQ="select id,prenom,nom,poste,eng_salaire from joueur inner join km_engagement on id=eng_joueur_id where eng_ekyp_id={$franchiseId} and eng_date_depart is null";
    
    $lastJQ = "select id from journee order by date desc limit 1";
    $lastJ = $db->getArray($lastJQ);
    $lastJourneeId = $lastJ[0][0];

    $offresCourantesQ="select id,nom,prenom,poste,off_montant,scl_salaire from joueur inner join km_offre on off_joueur_id=id and off_ekyp_id={$franchiseId} and off_mercato_id={$merkatoId} inner join km_join_joueur_salaire on jjs_joueur_id=id and jjs_journee_id={$lastJourneeId} inner join km_const_salaire_classe on jjs_salaire_classe_id=scl_id";

    $ekyp=$db->getArray($ekypQ);
    $sousContrat = $db->getArray($sousContratQ);
    $salaires=0;
    if ($sousContrat != NULL) {
    	foreach ($sousContrat as $contrat) {
    		$salaires += intval($contrat['eng_salaire']);
    	}
    }
    $offresCourantes = $db->getArray($offresCourantesQ);
?>
<section id="market">
<h1>Merkato</h1>
<div id="marketInfo" class="sectionInfo">
	<p>Marché ouvert du 17/11 au 19/11</p>
</div>
<div id="budgetInfo">
	<h2><?php echo $ekyp[0]['nom'];?></h2>
	<div class='budgetInfo_line'>
		<div class='budgetItem'><p>Contrats</p></div>
		<div class='budgetItem'>
			<div class='contract_positions_container'>
			<?php
				$positions = array();
				$positions['G']=NULL;
				$positions['D1']=NULL;
				$positions['D2']=NULL;
				$positions['M1']=NULL;
				$positions['M2']=NULL;
				$positions['A1']=NULL;
				$positions['A2']=NULL;
				if ($salaires > 0) { // manière rapide de savoir s'il y a des joueurs dans cette équipe
					foreach ($sousContrat as $contrat) {
						if ($contrat['poste']=='G') {
							if ($position['G']==NULL) {
								$position['G']=$contrat['prenom'].' '.$contrat['nom'];
							}
						}
						if ($contrat['poste']=='D') {
							if ($position['D1']==NULL) {
								$position['D1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['D2']==NULL) {
								$position['D2']=$contrat['prenom'].' '.$contrat['nom'];
							}
						}
						if ($contrat['poste']=='M') {
							if ($position['M1']==NULL) {
								$position['M1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['M2']==NULL) {
								$position['M2']=$contrat['prenom'].' '.$contrat['nom'];
							}
						}
						if ($contrat['poste']=='A') {
							if ($position['A1']==NULL) {
								$position['A1']=$contrat['prenom'].' '.$contrat['nom'];
							} else if ($position['A2']==NULL) {
								$position['A2']=$contrat['prenom'].' '.$contrat['nom'];
							}
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
			?>
		</div>
		</div>
	</div>
	<div class='budgetInfo_line'>
		<div class='budgetItem'>
			<p>Budget</p>
			<p><span class='budgetValue'><?php echo number_format($ekyp[0]['fin_solde'],1);?>&nbsp;Ka</span></p>
		</div>
		<div class='budgetItem'>
			<p>Masse salariale</p>
			<p><span class='budgetValue'><?php echo number_format($salaires,1);?>&nbsp;Ka</span></p>
		</div>
	</div>
</div>
<div id='clubPlayersList'>
		<p><label for='clubSelect'>Club</label>
		<select id='clubSelect'></select></p>
	
	<div id='playersList_effectif' class='playersList'>
		<h2 id='selectedClubName'></h2>
		<ul id='playersList_list'>
		</ul>
	</div>
</div>
<div id='playersCart'>
	<h2>Mon panier</h2>
	<form id='cartForm' method="POST" action="#">
		<div id='cartContent' class='playersList'>
			<ul>
				<?php 
				if ($offresCourantes == NULL) {
					echo "<li class='placeholder'>Faites glisser vos choix ici</li>";
				} else {
					foreach ($offresCourantes as $offre) {
						echo "<li id='playerCart{$offre['id']}'>";
						echo "<div class='playerFree'>";
						echo "<a class='removeCartBtn' href='#'>X</a>";
						echo $offre['prenom'].' '.$offre['nom'];
						echo "<span class='playerPosition'>{$offre['poste']}</span>";
						$sal = number_format($offre['scl_salaire'],1);
						echo "<span class='playerSalary' title='Salaire courant'>{$sal} Ka</span>";
						echo "<input type='hidden' value='{$offre['id']}' name='selectedPlayerId[]'>";
						$montant = number_format($offre['off_montant'],1);
						echo "<input class='spinnerInput' name='amountForIdo[]' value='{$montant}' size='3' maxlength='4' id='amountForIdo{$offre['id']}'/>";
						echo "</div></li>";
					}
				}
				//TODO : initialiser tout le jquery de la page :
				// - budget
				// - salaires
				// - spinners et X du panier
				?>
			</ul>
		</div>
		<div id='cartValue'>
			<p>Masse salariale disponible : <span></span> Ka</p>
			<p>Budget transfert restant : <span></span> Ka</p>
		</div>
		<button id="sendCartBtn">Envoyer</button>
	</form>
</div>
</section>
<script src="js/custom/km-market.js"></script>

<?php 
	function echoPosition($positionArray,$targetPos,$targetSpot) {
		echo "<div class='contract_position'>{$targetPos}<div class='pos_marker";
		if ($positionArray[$targetSpot] == NULL) {
		 	echo " pos_marker_empy'";
		} else {
			echo " pos_marker_filled' title='{$positionArray[$targetSpot]}'";
		}
		echo "></div></div>";
	}
?>