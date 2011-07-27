<?php

class Page_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';
    private $pagesTable = "pages";
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function get_title($controller=false, $action=false)
    {
    	if ($action=="index")$action=false;
    	if ($action) {
    		$query = $this->db->select('title')
    						  ->get_where($this->pagesTable, array('controller' => $controller,
        												   	       'view'       => $action,
        												  		  ));
    	}
    	else {
    		$query = $this->db->select('title')
    						  ->get_where($this->pagesTable, array('controller' => $controller));
    	}
        $page = $query->row_array();
        
        if (isset($page['title'])) {
        	return $page['title'];
        }
        else {
        	return false;
        }
    }
}