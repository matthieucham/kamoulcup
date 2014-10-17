<?php
class Player {
	
	public $ido;
	public $name;
	public $salary;
	public $prize;
	public $position;
    
    // Offre courante de la franchise qui reclame le joueur.
    public $offer;
	
	
	function __construct($i,$n,$s,$p,$pos) {
		$this->ido = $i;
		$this->name = $n;
		$this->salary = $s;
		$this->prize = $p;
		$this->position = $pos;
	}
	
	function get_name() {
        return $this->name;
    }
}
?>