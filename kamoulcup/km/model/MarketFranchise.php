<?php

class MarketFranchise {
	public $ido;
	public $name;
	public $transferBudget;
	public $salaryBudget;
	// array of PosteEffectif
	public $effectif;
	
	function __construct($frId,$frName,$frTr,$frSal,$frEff) {
		$this->ido = $frId;
		$this->name = $frName;
		$this->transferBudget = $frTr;
		$this->salaryBudget = $frSal;
		$this->effectif = $frEff;
	}
}

class PosteEffectif {

	// G,D,M ou A
	public $position;
	// Prenom-Nom du joueur affecté.
	public $affectedPlayer;
	
	function __construct($p,$ap) {
		$this->position = $p;
		$this->affectedPlayer = $ap;
	}
}

?>