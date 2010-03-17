<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Breadcrumbs Model
* 
* Author:  Ben Edmunds
* Created:  9.23.2009 
* 
* Description:  Library to create dynamic breadcrumbs according to the page setup in the database
* 
*/

class Breadcrumbs_model extends Model {

    var $title   = '';
    var $content = '';
    var $date    = '';
    private $pagesTable = "pages";
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_page($id=false,$controller=false,$action=false)
    {
    	if ($action=="index")$action=false;
    	if ($id) {
        	$query = $this->db->get_where($this->pagesTable, array('id' => $id));
    	}
    	else {
    		if ($action) {
    			$query = $this->db->get_where($this->pagesTable, array('controller' => $controller,
        													   	       'view'       => $action,
        													          ));
    		}
    		else {
    			$query = $this->db->get_where($this->pagesTable, array('controller' => $controller));
    		}
    	}
        return $query->row();
    }

}