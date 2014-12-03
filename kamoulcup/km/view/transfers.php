<section id='transfers'>
    <h1>Bilan des transferts</h1>
<?php
    include_once('../ctrl/mercatoManager.php');
    include_once('../ctrl/transferManager.php');
    $mercatos = listProcessedMercatos($_SESSION['myChampionnatId']);
    if ($mercatos == NULL) {
        echo "<p>Aucun mercato terminé pour l'instant</p>";
    } else {
        foreach ($mercatos as $mercato) {
            echo "<h2>Transferts du {$mercato['dateFermeture']}</h2>";
            $trs = listMercatoTransfers($mercato['mer_id']);
            if ($trs == NULL) {
                echo "<p>Aucun transfert enregistré lors de ce mercato</p>";
            } else {
                echo "<ul class='fa-ul'>";
                foreach ($trs as $tr) {
                    $montant = number_format($tr['off_montant'],1);
                    $deuxieme = number_format($tr['deuxiemeOffre'],1);
                    echo "<li><i class='fa-li fa fa-shopping-cart bullet'></i>{$tr['prenom']} {$tr['nomJoueur']} <i class='fa fa-arrow-right'></i> {$tr['nomEkyp']} pour <b>{$montant} Ka</b>";
                    if ($deuxieme > 0) {
                        echo " (Deuxième meilleure offre : {$deuxieme} Ka)";
                    }
                    echo "</li>";
                }
                echo "</ul>";
            }
            
            
        }
    }
?>
    
</section>