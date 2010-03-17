<?php

class Users_model extends Model {

    var $title   = '';
    var $content = '';
    var $date    = '';
    private $usersTable = "users";
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    

	function get_user($id)
    {
        $query = $this->db->get_where($this->usersTable, array('id'       => $id,
        													   'active'   => '1'));
        return $query->result();
    }
    
    function get_users()
    {
        $query = $this->db->get_where($this->usersTable, array('active'   => '1'));
        return $query->result();
    }
    

	function get_inactive_users()
    {
        $query = $this->db->get_where($this->usersTable, array('active'   => '0'));
        return $query->result();
    }
    
	function get_notification_users($select='email')
    {
    	$query = $this->db->select($select);
        $query = $this->db->get_where($this->usersTable, array('notify'   => '1',
        													   'active'   => '1'));
        return $query->result();
    }
}