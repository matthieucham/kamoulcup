<?php
include("../model/model_include.php");

$data = array(new Club(1,"Paris", array(new Player(147,"Nicolas Douchez",4,0,'G'),new Player(14,"Lalaïna Nomenjanahary-Poulidor",12,25.9,'D'),new Player(121,"Alphousseiny Keita",4,12.4,'M'),new Player(555,"Blaise Matuidi",8,-1,'M'),new Player(1258,"Zlatan",20,0,'A'))),new Club(2,"Toulouse", array(new Player(444,"Julien Capoue",8,-1,'D'),new Player(8523,"Alberto Braithwaite",16,0,'A'))), new Club(3,"Lyon",array(new Player(7,"A Lopes",8,5,'G'),new Player(778,"Malbranque",8,5,'M'))));

echo json_encode($data);

?>
