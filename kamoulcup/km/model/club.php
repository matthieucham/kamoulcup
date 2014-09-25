<?php

class Club {
	public $ido;
	public $name;
	public $players;
	
	function __construct($i,$n,$p) {
		$this->ido = $i;
		$this->name = $n;
		$this->players = $p;
	}
	
	function get_name() {
        return $this->name;
    }
}
?>