<?php
    include_once('../ctrl/joueurManager.php');
    include_once('../ctrl/journeeManager.php');
    include_once('../ctrl/transferManager.php');

	if (! isset($_GET['joueurid'])) {
		echo '<p class=\"error\">Pas de JoueurId !</p>';
		exit;
	}
	$joueurId = ($_GET['joueurid']);
    $lastJournee = getLastJournee();
    $joueurCommonInfo = getJoueurCommonInfo($joueurId);
    //$joueur = getJoueur($joueurId,$lastJournee['id']);
    
    $chpId = $_SESSION['myChampionnatId'];
    $joueurChpInfo = getJoueurChampionnatInfo($joueurId,$chpId);
?>

<section id="player">
    <?php
	echo "<div class='sectionInfo'>
        <h2>{$joueurCommonInfo['prenom']} {$joueurCommonInfo['nomJoueur']}</h2>
		<p><span class='playerPosition'>{$joueurCommonInfo['poste']}</span> <a href='./index.php?page=detailClub&clubid={$joueurCommonInfo['idClub']}'>{$joueurCommonInfo['nomClub']}</a></p>
	   </div>";
    ?>
<div id="timeline">
	<div id="cd-timeline" class="cd-container">
		<!-- Présentation sous forme de timeline -->
        <?php
        $transfers = listPlayerTransfers($joueurId,$chpId);
        if ($transfers != NULL) {
            $lastDateDepart = NULL;
            $nbTransfers = sizeof($transfers);
            for ($i=0;$i<$nbTransfers;$i++) {
                $tr=$transfers[$i];
                $isLast = ($i+1 == $nbTransfers);
                
                echo "<div class='cd-timeline-block'>
        	       <div class='cd-timeline-img cd-picture'>";
                echo "<i class='fa fa-exchange'></i>";
                echo "</div> <!-- cd-timeline-img -->
                    <div class='cd-timeline-content'>";
                $montant = number_format(round($tr['eng_montant'],1),1);
                echo "<h2>Transfert</h2>
            	       <p>Acheté par {$tr['nomEkyp']} pour {$montant} Ka</p>
            	       <span class='cd-date'>{$tr['dateArrivee']}</span>";
                echo "</div> <!-- cd-timeline-content -->
    	           </div> <!-- cd-timeline-block -->";
                // Faut il ensuite faire appaître un evènement "Libéré" ?
                $showFinContrat=false;
                if ($isLast) {
                    $currentDateDepart = $tr['eng_date_depart'];
                    $showFinContrat = $currentDateDepart != NULL;
                } else {
                    $nextDateArrivee = $transfers[$i+1]['eng_date_arrivee'];
                    $currentDateDepart = $tr['eng_date_depart'];
                    if ($currentDateDepart != $nextDateArrivee) {
                        //Fin de contrat à matérialiser
                        $showFinContrat = true;
                    }
                }
                if ($showFinContrat) {
                    echo "<div class='cd-timeline-block'>
        	       <div class='cd-timeline-img cd-picture'>";
                    echo "<i class='fa fa-suitcase'></i>";
                    echo "</div> <!-- cd-timeline-img -->
                    <div class='cd-timeline-content'>";
                    echo "<h2>Fin de contrat</h2>
            	       <p>Libéré par {$tr['nomEkyp']}</p>
            	       <span class='cd-date'>{$tr['dateDepart']}</span>";
                    echo "</div> <!-- cd-timeline-content -->
    	               </div> <!-- cd-timeline-block -->";
                }
            }
        }
        ?>
	</div>
	</div>
	<div id="playerInfo">
		<ul class="fa-ul">
            <?php
                $sal=0;
                if ($joueurChpInfo != NULL) {
                    echo "<li><i class='fa-li fa fa-home'></i>Sous contrat avec <a href='./index.php?kmpage=otherTeam&franchiseid={$joueurChpInfo['fra_id']}'>{$joueurChpInfo['fra_nom']}</a></li>";
                    $sal = round($joueurChpInfo['eng_salaire'],0);
                    echo "<li><i class='fa-li fa fa-pencil-square-o'></i>Salaire contractuel : {$sal} Ka</li>";
                } else {
                    echo "<li><i class='fa-li fa fa-suitcase'></i>Sans contrat</li>";
                }
                $actualSal = round($joueurCommonInfo['scl_salaire'],0);
                $ecart = $actualSal - $sal;
                if ($ecart > 0) {
                    $showEcart = '+'.$ecart;
                } else {
                    $showEcart = ''.$ecart;
                }
                echo "<li><i class='fa-li fa fa-futbol-o'></i>Salaire virtuel : {$actualSal} Ka";
                if ($sal > 0) {
                    echo " ({$showEcart})";
                }
                echo "</li>";
            if ($joueurChpInfo != NULL) {
                if ($joueurChpInfo['ltr_montant'] != NULL ) {
                    $mt = number_format(round($joueurChpInfo['ltr_montant'],1),1);
                    echo "<li class='highlight'><i class='fa-li fa fa-money'></i>En vente pour {$mt} Ka</li>";
                }
            }
            ?>
		</ul>
	</div>
	<div id="playerPerf">
	<h2>Historique des performances</h2>
    <?php
        $histo = getJoueurHistorique($joueurId,$chpId);
        if ($histo == NULL) {
            echo "<p>Rien pour l'instant</p>" ;
        } else {
            echo "<table width='100%'><thead><tr>
		          <th>Tour</th><th>Journée L1</th><th>Rencontre</th><th>Franchise</th><th>Score</th><th>Salaire</th>
                  </tr></thead><tbody>";
            foreach ($histo as $ligne) {
                echo "<tr><td>{$ligne['cro_numero']}</td><td>{$ligne['numero']}</td><td><a href='index.php?kmpage=home&page=detailClub&clubid={$ligne['idClubDom']}'>{$ligne['nomClubDom']}</a> <a href='index.php?kmpage=home&page=detailMatch&rencontreid={$ligne['idRencontre']}'>{$ligne['buts_club_dom']} &nbsp;-&nbsp;{$ligne['buts_club_ext']}</a> <a href='index.php?kmpage=home&page=detailClub&clubid={$ligne['idClubExt']}'>{$ligne['nomClubExt']}</a></td><td>";
                if ($ligne['fra_nom'] == NULL) {
                    echo "Sans contrat</td>";
                } else {
                    echo "<a href='./index.php?kmpage=otherTeam&franchiseid={$ligne['fra_id']}'>{$ligne['fra_nom']}</a></td>";
                }
                $perf = number_format(round($ligne['jpe_score'],2),2);
                $sal = number_format(round($ligne['scl_salaire'],0),0);
                echo "<td>{$perf}</td><td>{$sal} Ka</td></tr>";
            }
            echo "</tbody></table>";
        }
    ?>
	</div>
</section>
