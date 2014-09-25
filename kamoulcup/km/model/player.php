<?php
class Player {
	
	public $ido;
	public $name;
	public $salary;
	public $prize;
	public $position;
	
	
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