<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth
* 
* Author:  Ben Edmunds
* Created:  10.01.2009 
* 
* Description:  Modified auth system based on redux_auth with extensive customization.  Original license is below.
* Original Author name has been kept but that does not mean that the method has not been modified.
* 
*/

/*
 * ----------------------------------------------------------------------------
 * "THE BEER-WARE LICENSE" :
 * <thepixeldeveloper@googlemail.com> wrote this file. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy me a beer in return Mathew Davies
 * ----------------------------------------------------------------------------
 */
 
class auth
{
	/**
	 * CodeIgniter global
	 *
	 * @var string
	 **/
	protected $ci;

	/**
	 * account status ('not_activated', etc ...)
	 *
	 * @var string
	 **/
	protected $status;

	/**
	 * __construct
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function __construct()
	{
		$this->ci =& get_instance();
		$email = $this->ci->config->item('email');
		$this->ci->load->library('email', $email);
		$this->ci->load->model('auth_model');
	}
	
	/**
	 * Activate user.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function activate($code)
	{
		return $this->ci->auth_model->activate($code);
	}
	
	/**
	 * Deactivate user.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function deactivate($id)
	{
	    return $this->ci->auth_model->deactivate($id);
	}
	
	/**
	 * Change password.
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function change_password($identity, $old, $new)
	{
        return $this->ci->auth_model->change_password($identity, $old, $new);
	}

	/**
	 * forgotten password feature
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password($email)
	{
		$forgotten_password = $this->ci->auth_model->forgotten_password($email);
		
		if ($forgotten_password)
		{
			// Get user information.
			$profile = $this->ci->auth_model->profile($email);

			$data = array('identity'                => $profile->{$this->ci->config->item('identity')},
    			          'forgotten_password_code' => $this->ci->auth_model->forgotten_password_code);
                
			$message = $this->ci->load->view($this->ci->config->item('email_templates').'forgotten_password', $data, true);
				
			$this->ci->email->clear();
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from("admin@".$this->ci->config->item('site_title'), $this->ci->config->item('site_title'));
			$this->ci->email->to($profile->email);
			$this->ci->email->subject('Email Verification (Forgotten Password)');
			$this->ci->email->message($message);
			return $this->ci->email->send();
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function forgotten_password_complete($code)
	{
	    $identity                 = $this->ci->config->item('identity');
	    $profile                  = $this->ci->auth_model->profile($code);
		$forgotten_password_complete = $this->ci->auth_model->forgotten_password_complete($code);

		if ($forgotten_password_complete)
		{
			$data = array('identity'    => $profile->{$identity},
				         'new_password' => $this->ci->auth_model->new_password);
            
			$message = $this->ci->load->view($this->ci->config->item('email_templates').'new_password', $data, true);
				
			$this->ci->email->clear();
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from("admin@".$this->ci->config->item('site_title'), $this->ci->config->item('site_title'));
			$this->ci->email->to($profile->email);
			$this->ci->email->subject('New Password');
			$this->ci->email->message($message);
			return $this->ci->email->send();
		}
		else
		{
			return false;
		}
	}

	/**
	 * register
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function register($username, $password, $email, $firstName='', $lastName='', $company='')
	{
	    $email_activation = $this->ci->config->item('email_activation');
	    $email_folder     = $this->ci->config->item('email_templates');

		if (!$email_activation)
		{
			return $this->ci->auth_model->register($username, $password, $email, $firstName, $lastName, $company);
		}
		else
		{
			$register = $this->ci->auth_model->register($username, $password, $email);
            
			if (!$register) { return false; }

			$deactivate = $this->ci->auth_model->deactivate($username);

			if (!$deactivate) { return false; }

			$activation_code = $this->ci->auth_model->activation_code;

			$data = array('username' => $username,
        				'password'   => $password,
        				'email'      => $email,
        				'activation' => $activation_code);
            
			$message = $this->ci->load->view($email_folder.'activation', $data, true);
            
			$this->ci->email->clear();
			$this->ci->email->set_newline("\r\n");
			$this->ci->email->from("admin@".$this->ci->config->item('site_title'), $this->ci->config->item('site_title'));
			$this->ci->email->to($email);
			$this->ci->email->subject('Email Activation (Registration)');
			$this->ci->email->message($message);
			
			return $this->ci->email->send();
		}
	}
	
	/**
	 * login
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function login($identity, $password)
	{
		return $this->ci->auth_model->login($identity, $password);
	}
	
	/**
	 * logout
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logout()
	{
	    $identity = $this->ci->config->item('identity');
	    $this->ci->session->unset_userdata($identity);
	    $this->ci->session->unset_userdata('group');
	    $this->ci->session->unset_userdata('id');
	    $this->ci->session->unset_userdata('company_id');
		$this->ci->session->sess_destroy();
	}
	
	/**
	 * logged_in
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function logged_in()
	{
	    $identity = $this->ci->config->item('identity');
		return ($this->ci->session->userdata($identity)) ? true : false;
	}
	
	/**
	 * is_admin
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function is_admin()
	{
	    $admin_group = $this->ci->config->item('admin_group');
	    $user_group = $this->ci->session->userdata('group');
	    if ($user_group == $admin_group) {
	    	return true;
	    }
	    else {
	    	return false;
	    }
	}
	
	/**
	 * Profile
	 *
	 * @return void
	 * @author Mathew
	 **/
	public function profile()
	{
	    $session  = $this->ci->config->item('identity');
	    $identity = $this->ci->session->userdata($session);
	    return $this->ci->auth_model->profile($identity);
	}
	
	/**
	 * Get Users
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function get_users()
	{
	    $users = $this->ci->auth_model->get_users();
	    return $users;
	}
	
	/**
	 * Get Active Users
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function get_active_users()
	{
	    $users = $this->ci->auth_model->get_active_users();
	    return $users;
	}
	
	/**
	 * Get User
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function get_user($id)
	{
	    $user = $this->ci->auth_model->get_user($id);
	    return $user;
	}

	
	/**
	 * Get Users Group
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function get_users_group($id)
	{
	    $group = $this->ci->auth_model->get_users_group($id);
	    return $group;
	}
	
}