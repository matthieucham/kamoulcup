<?php
    include_once('../../../includes/db.php');
    include_once('../../ctrl/roundManager.php');
    include_once('../../ctrl/rankingManager.php');
    include_once('../../view/fragments/fixturesRound.php');
    $roundId = $_GET['roundid'];
    
    return displayTeamRanking($roundId);
?>