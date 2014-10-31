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
    $joueur = getJoueur($joueurId,$lastJournee['id']);
?>

<section id="player">
    <?php
	echo "<div class='sectionInfo'>
        <h2>{$joueur['prenom']} {$joueur['nomJoueur']}</h2>
		<p><span class='playerPosition'>{$joueur['poste']}</span> <a href='./index.php?page=detailClub&clubid={$joueur['idClub']}'>{$joueur['nomClub']}</a></p>
	   </div>";
    ?>
<div id="timeline">
	<div id="cd-timeline" class="cd-container">
		<!-- Présentation sous forme de timeline -->
        <?php
        $transfers = listPlayerTransfers($joueurId);
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
                if ($joueur['eng_ekyp_id'] != NULL && $joueur['eng_date_depart'] == NULL) {
                    echo "<li><i class='fa-li fa fa-home'></i>Sous contrat avec <a href='./index.php?kmpage=otherTeam&franchiseid={$joueur['idEkyp']}'>{$joueur['nomEkyp']}</a></li>";
                    $sal = round($joueur['eng_salaire'],0);
                    echo "<li><i class='fa-li fa fa-pencil-square-o'></i>Salaire contractuel : {$sal} Ka</li>";
                } else {
                    echo "<li><i class='fa-li fa fa-suitcase'></i>Sans contrat</li>";
                }
                $actualSal = round($joueur['scl_salaire'],0);
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
                if ($joueur['ltr_montant'] != NULL && $joueur['eng_date_depart'] == NULL) {
                    $mt = number_format(round($joueur['ltr_montant'],1),1);
                    echo "<li class='highlight'><i class='fa-li fa fa-money'></i>En vente pour {$mt} Ka</li>";
                }
            ?>
		</ul>
	</div>
	<div id="playerPerf">
	<h2>Historique des performances</h2>
    <?php
        $histo = getJoueurHistorique($joueurId);
        if ($histo == NULL) {
            echo "<p>Rien pour l'instant</p>" ;
        } else {
            echo "<table width='100%'><thead><tr>
		          <th>Journée</th><th>Rencontre</th><th>Franchise</th><th>Score</th><th>Salaire</th>
                  </tr></thead><tbody>";
            foreach ($histo as $ligne) {
                echo "<tr><td>{$ligne['numero']}</td><td><a href='index.php?kmpage=home&page=detailClub&clubid={$ligne['idClubDom']}'>{$ligne['nomClubDom']}</a> <a href='index.php?kmpage=home&page=detailMatch&rencontreid={$ligne['idRencontre']}'>{$ligne['buts_club_dom']} &nbsp;-&nbsp;{$ligne['buts_club_ext']}</a> <a href='index.php?kmpage=home&page=detailClub&clubid={$ligne['idClubExt']}'>{$ligne['nomClubExt']}</a></td><td>";
                if ($ligne['nomEkyp'] == NULL) {
                    echo "Sans contrat</td>";
                } else {
                    echo "<a href='./index.php?kmpage=otherTeam&franchiseid={$ligne['idEkyp']}'>{$ligne['nomEkyp']}</a></td>";
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
