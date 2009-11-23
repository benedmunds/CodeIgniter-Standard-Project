<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Config
* 
* Author:  Ben Edmunds
* Created:  10.01.2009 
* 
* Description:  Modified auth system based on redux_auth with extensive customization.  Original license is below.
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

	/**
	 * Tables.
	 **/
	$config['tables']['groups']  = 'groups';
	$config['tables']['users']   = 'users';
	$config['tables']['meta']    = 'meta';
	
	/**
	 * Default group, use name
	 */
	$config['default_group']     = 'members';
	
	/**
	 * Default administrators group, use name
	 */
	$config['admin_group']       = 'admin';
	 
	/**
	 * Meta table column you want to join WITH.
	 * Joins from users.id
	 **/
	$config['join']              = 'user_id';
	
	/**
	 * Columns in your meta table,
	 * id not required.
	 **/
	$config['columns']           = array('first_name', 'last_name');
	
	/**
	 * A database column which is used to
	 * login with.
	 **/
	$config['identity']          = 'email';

	/**
	 * Email Activation for registration
	 **/
	$config['email_activation']  = false;
	
	/**
	 * Folder where email templates are stored.
     * Default : auth/
	 **/
	$config['email_templates']   = 'auth/';

	/**
	 * Salt Length
	 **/
	$config['salt_length']       = 10;
	
?>