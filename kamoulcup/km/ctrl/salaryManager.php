<?php
    include_once("../../includes/db.php");
    
    function getRealSalary($playerId,$journeeId) {
        global $db;
        $salQ = "select scl_salaire from km_const_salaire_classe inner join km_join_joueur_salaire on jjs_salaire_classe_id=scl_id and jjs_journee_id={$journeeId} and jjs_joueur_id={$playerId} limit 1";
        $sal = $db->getArray($salQ);
        return round(floatval($sal[0][0]),1);
    }
?>