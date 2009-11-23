<?php

class Welcome extends MY_Controller {

	function __construct() {
		parent::__construct();	
	}
	
	function __destruct() {
		parent::__destruct();	
	}
	
	function index() {
		$this->data['title'] = "Welcome";
		$this->render();
	}
}
