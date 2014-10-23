<section id='transfers'>
    <h1>Bilan des transferts</h1>
<?php
    $mecatQ = "select mer_id,mer_date_fermeture from km_mercato where mer_processed=1 order by mer_date_fermeture desc";
    $mercatos = $db->getArray($mecatQ);
    if ($mercatos == NULL) {
        echo "<p>Aucun mercato terminé pour l'instant</p>";
    } else {
        foreach ($mercatos as $mercato) {
            $mercatoDate = date_create($mercato['mer_date_fermeture']);
            $dateF = date_format($mercatoDate,'d-m-Y H:i');
            $mercatoId = $mercato['mer_id'];
            echo "<h2>Transferts du {$dateF}</h2>";
            $trsQ = "select ek.nom as nomEkyp, jo.prenom, jo.nom as nomJoueur, off_montant from km_offre inner join ekyp as ek on off_ekyp_id=ek.id inner join joueur as jo on off_joueur_id=jo.id where off_winner=1 and off_mercato_id={$mercatoId}";
            $trs = $db->getArray($trsQ);
            if ($trs == NULL) {
                echo "<p>Aucun transfert enregistré lors de ce mercato</p>";
            } else {
                echo "<ul class='fa-ul'>";
                foreach ($trs as $tr) {
                    $montant = number_format($tr['off_montant'],1);
                    echo "<li><i class='fa-li fa fa-shopping-cart bullet'></i>{$tr['prenom']} {$tr['nomJoueur']} <i class='fa fa-arrow-right'></i> {$tr['nomEkyp']} pour <b>{$montant} Ka</b></li>";
                }
                echo "</ul>";
            }
            
            
        }
    }
?>
    
</section>