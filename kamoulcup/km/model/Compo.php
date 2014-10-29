<?php
class Compo {
    // Tableaux:
    public $gardiens;
    public $defenseurs;
    public $milieux;
    public $attaquants;
    public $remplacants;
    
    function __construct($g,$d,$m,$a,$r) {
		$this->gardiens = $g;
		$this->defenseurs = $d;
        $this->milieux = $m;
        $this->attaquants = $a;
        $this->remplacants = $r;
	}
    
}

?>