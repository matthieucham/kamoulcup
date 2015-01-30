<?php

class CompoPlayer {
    public $ido;
    public $position;
    public $nom;
    public $club;
    public $score;
    public $swappedIn;
    public $swappedOut;
    public $swapTime;
    
    function __construct($i,$p,$n,$c,$s,$si,$so,$st) {
		$this->ido = $i;
		$this->position = $p;
        $this->nom = $n;
        $this->club = $c;
        $this->score = $s;
        $this->swappedIn = $si;
        $this->swappedOut = $so;
        $this->swaptime = $st;
	}
}
?>