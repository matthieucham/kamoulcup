<?php

class PosteEffectif {

	// G,D,M ou A
	public $position;
	// Prenom-Nom du joueur affecté.
	public $affectedPlayer;
	
	function __construct($p) {
		$this->position = $p;
		$this->affectedPlayer = NULL;
	}
	
	function __construct($p,$ap) {
		$this->position = $p;
		$this->affectedPlayer = $ap;
	}
}

?>