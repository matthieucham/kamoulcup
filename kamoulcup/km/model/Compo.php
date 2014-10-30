<?php
class Compo {
    // Tableaux:
    public $gardiens;
    public $defenseurs;
    public $milieux;
    public $attaquants;
    public $remplacants;
    public $journee;
    public $score;
    
    function __construct($g,$d,$m,$a,$r,$j) {
		$this->gardiens = $g;
		$this->defenseurs = $d;
        $this->milieux = $m;
        $this->attaquants = $a;
        $this->remplacants = $r;
        $this->journee=$j;
        $this->score = $this->get_score();
	}
    
    function get_score() {
        $sc = 0;
        foreach ($this->gardiens as $g) {
            $sc += $g->score;
        }
        foreach ($this->defenseurs as $d) {
            $sc += $d->score;
        }
        foreach ($this->milieux as $m) {
            $sc += $m->score;
        }
        foreach ($this->attaquants as $a) {
            $sc += $a->score;
        }
        return round($sc,2);
    }
    
}

?>