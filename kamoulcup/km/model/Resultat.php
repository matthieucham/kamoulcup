<?php

class Resultat {
	public $success=true;
	public $message="";
	
	function __construct($s,$msg="") {
		$this->success = $s;
		$this->message = $msg;
	}
}
?>