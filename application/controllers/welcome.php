<?php

class Welcome extends MY_Controller {

	function __construct() {
		parent::__construct();	
	}
	
	function index() {
		$this->data['title'] = "Welcome";
		
		$this->render();
	}
}
