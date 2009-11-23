<?php

class Admin extends MY_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->library(array('auth','session','form_validation'));
    }
	
	function __destruct() {
		parent::__destruct();	
	}
 
    //redirect if needed, otherwise display the admin cp
    function index() {
    	if (!$this->auth->logged_in()) {
	    	//redirect them to the login page
			redirect("admin/login", 'refresh');
    	}
    	elseif (!$this->auth->is_admin()) {
    		//redirect them to the home page because they must be an administrator to view this
			redirect("/", 'refresh');
    	}
    	else {
    		//list the users
    		$this->data['users'] = $this->auth->get_users();
    		$this->render();
    	}
    }
    
    //log the user in
    function login() {
        $this->data['title'] = "Login";
        
        //validate form input
    	$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
	    $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) { //check to see if the user is logging in
        	$email    = $this->input->post('email');
	        $password = $this->input->post('password');
	        
	        if ($this->auth->login($email, $password)) { //if the login is successful
	        	//redirect them back to the page they came from
	        	$this->save_url();
	        	$this->session->set_flashdata('message', "Logged In Successfully");
	        	redirect($this->previous_controller_name."/".$this->previous_action_name, 'refresh');
	        }
	        else { //if the login was un-successful
	        	//redirect them back to the login page
	        	$this->save_url();
	        	$this->session->set_flashdata('message', "Login In-Correct");
	        	redirect("admin/login/", 'refresh');
	        }
        }
		else {  //the user is not logging in so display the login page
		    $this->session->set_flashdata('message', validation_errors());
		    
			$this->data['email']      = array('name'    => 'email',
                                              'id'      => 'email',
                                              'type'    => 'text',
                                              'value'   => $this->form_validation->set_value('email'),
                                             );
            $this->data['password']   = array('name'    => 'password',
                                              'id'      => 'password',
                                              'type'    => 'password',
                                             );
	        
            $this->save_url();
        	$this->render();
		}
    }
    
    //log the user out
	function logout() {
        $this->data['title'] = "Logout";
        
        //log the user out
        $logout = $this->auth->logout();
			    
        //redirect them back to the page they came from
        redirect($this->previous_controller_name."/".$this->previous_action_name, 'refresh');
    }
    
    //change password [incomplete]
	function change_password() {	    
	    $this->form_validation->set_rules('old', 'Old password', 'required');
	    $this->form_validation->set_rules('new', 'New Password', 'required|matches[new_repeat]');
	    $this->form_validation->set_rules('new_repeat', 'Repeat New Password', 'required');
	    
	    if ($this->input->post('old')) { //check to see if the user is changing their password
		    if ($this->form_validation->run() == false) {
		        //set the flash data error message and redirect back to the page they came from		    }
		        $this->session->set_flashdata('message', validation_errors());
				redirect("admin/change_password", 'refresh');
		    }
		    else {
		        $old = $this->input->post('oldPassword');
		        $new = $this->input->post('newPassword');
		        
		        $identity = $this->session->userdata($this->config->item('identity'));
		        
		        $change = $this->auth->change_password($identity, $old, $new);
			
	    		if ($change) {
	    			$this->session->set_flashdata('message', 'Password Changed Successfully');
	    			$this->logout('admin','login');
	    		}
	    		else {
	    			$this->session->set_flashdata('message', 'Password Change Failed');
	    			$this->logout('admin','login');
	    		}
		    }
	    }
	    else { //display the password change page
	    	$this->render();
	    }
	}
	
	//forgot password [incomplete]
	function forgot_password() {
	    if ($this->input->post('email')) { //check to see if the user has forgotten their password
			$this->form_validation->set_rules('email', 'Email Address', 'required');
		    if ($this->form_validation->run() == false) {
		        //set the flash data error message and redirect back to the page they came from		    }
			    $this->session->set_flashdata('message', validation_errors());
				redirect("admin/forgot_password", 'refresh');
		    }
		    else {
		        $email = $this->input->post('email');
				$forgotten = $this->auth->forgotten_password($email);
			    
				if ($forgotten) {
					$this->session->set_flashdata('message', 'An email has been sent, please check your inbox.');
		            redirect("admin/login", 'refresh');
				}
				else {
					$this->session->set_flashdata('message', 'The email failed to send, try again.');
		            redirect("admin/forgot_password", 'refresh');
				}
		    }
	    }
	    else { //display the forgot password form
	    	$this->render();
	    }
	}
	
	//forgot password - final step [incomplete]
	public function forgotten_password_complete() {
		//verify the posted data
	    $this->form_validation->set_rules('code', 'Verification Code', 'required');
	    if ($this->form_validation->run() == false) {
	        redirect("admin/forgot_password", 'refresh');
	    }
	    else {
	        $code = $this->input->post('code');
			$forgotten = $this->auth->forgotten_password_complete($code);
		    
			if ($forgotten) {  //if the reset worked then send them to the login page
				$this->session->set_flashdata('message', 'An email has been sent, please check your inbox.');
	            redirect("admin/login", 'refresh');
			}
			else { //if the reset didnt work then send them back to the forgot password page
				$this->session->set_flashdata('message', 'The email failed to send, try again.');
	            redirect("admin/forgot_password", 'refresh');
			}
	    }
	}

	//activate the user
	function activate($id) {        
		if ($this->auth->logged_in() && $this->auth->is_admin()) {
	        //activate the user
	        $this->auth->activate($id);
		}
        //redirect them back to the admin page
        redirect("admin", 'refresh');
    }
    
    //deactivate the user
	function deactivate($id) {        
		if ($this->auth->logged_in() && $this->auth->is_admin()) {
	        //de-activate the user
	        $this->auth->deactivate($id);
		} 
        //redirect them back to the admin page
        redirect("admin", 'refresh');
    }
    
    //create a new user
	function create_user() {  
        $this->data['title'] = "Create User";
        $this->load->library(array('session','form_validation'));
              
		if ($this->auth->logged_in() && $this->auth->is_admin()) {
	        //validate form input
	    	$this->form_validation->set_rules('firstName', 'First Name', 'required|xss_clean');
	    	$this->form_validation->set_rules('lastName', 'Last Name', 'required|xss_clean');
    		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
    		$this->form_validation->set_rules('company', 'Company Name', 'required|xss_clean');
	    	$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]|matches[password_confirm]');
	    	$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');

	        if ($this->form_validation->run() == true) { //check to see if we are creating the user
				$username  = strtolower($this->input->post('firstName'))." ".strtolower($this->input->post('lastName'));
	        	$firstName = $this->input->post('firstName');
	        	$lastName  = $this->input->post('lastName');
	        	$email     = $this->input->post('email');
	        	$password  = $this->input->post('password');
	        	$company   = $this->input->post('company');
	        	
	        	$this->auth->register($username,$password,$email,$firstName,$lastName,$company);
	        	
	        	//redirect them back to the admin page
	        	$this->session->set_flashdata('message', "User Created");
       			redirect("admin", 'refresh');
			} 
			else { //display the create user form
				$this->session->set_flashdata('message', validation_errors());
				
				$this->data['firstName']          = array('name'    => 'firstName',
			                                              'id'      => 'firstName',
			                                              'type'    => 'text',
			                                              'value'   => $this->form_validation->set_value('firstName'),
			                                             );
	            $this->data['lastName']           = array('name'    => 'lastName',
			                                              'id'      => 'lastName',
			                                              'type'    => 'text',
			                                              'value'   => $this->form_validation->set_value('lastName'),
			                                             );
	            $this->data['email']              = array('name'    => 'email',
			                                              'id'      => 'email',
			                                              'type'    => 'text',
			                                              'value'   => $this->form_validation->set_value('email'),
			                                             );
	            $this->data['company']            = array('name'    => 'company',
			                                              'id'      => 'company',
			                                              'type'    => 'text',
			                                              'value'   => $this->form_validation->set_value('company'),
			                                             );
			    $this->data['password']           = array('name'    => 'password',
			                                              'id'      => 'password',
			                                              'type'    => 'password',
			                                              'value'   => $this->form_validation->set_value('password'),
			                                             );
	            $this->data['password_confirm']   = array('name'    => 'password_confirm',
	                                                      'id'      => 'password_confirm',
	                                                      'type'    => 'password',
	                                                      'value'   => $this->form_validation->set_value('password_confirm'),
	                                                     );
	            $this->render();
			}
		}
    }

}