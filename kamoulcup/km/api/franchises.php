<?php
include("../model/model_include.php");

$data = new MarketFranchise(15,'Legion of Doom',100,60,array(new PosteEffectif('G','Alphonse Areola'),new PosteEffectif('D','Brice Dja Djédjé'), new PosteEffectif('D',NULL), new PosteEffectif('M','Yann Cahuzac'),new PosteEffectif('M',NULL),new PosteEffectif('A',NULL), new PosteEffectif('A',NULL)));


echo json_encode($data);

?>
