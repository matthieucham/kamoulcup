<?php

class CompoPlayer {
    public $ido;
    public $position;
    public $nom;
    public $club;
    public $score;
    
    function __construct($i,$p,$n,$c,$s) {
		$this->ido = $i;
		$this->position = $p;
        $this->nom = $n;
        $this->club = $c;
        $this->score = $s;
	}
}
?>