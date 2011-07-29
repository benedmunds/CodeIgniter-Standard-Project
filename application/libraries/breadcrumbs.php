<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Breadcrumbs
* 
* Author:  Ben Edmunds
* Created:  9.23.2009 
* 
* Description:  Library to create dynamic breadcrumbs according to the page setup in the database
* 
*/
class breadcrumbs
{
	/**
	 * CodeIgniter global
	 *
	 **/
	protected $ci;


	/**
	 * __construct
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function __construct()
	{
		//Get an Instance of CodeIgniter
		$this->ci =& get_instance();
		//load model
		$this->ci->load->model('breadcrumbs_model');
	}
	
	/**
	 * Generate Breadcrumb
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/
	public function generate_breadcrumb()
	{
		//define the controller and action
		$controller = $this->ci->router->fetch_directory() . $this->ci->router->fetch_class();
		$view = $this->ci->router->fetch_method();
		//define the breadcrumb variable
		$breadcrumb = '';
		
		//pull the current page from the model
		$page = $this->ci->breadcrumbs_model->get_page(false,$controller,$view);
		
		if (is_object($page) && $page->parent_id != ''){ //if the page is a child object
			$parent[0] = $this->ci->breadcrumbs_model->get_page($page->parent_id);
			if ($parent[0]->parent_id != '') { //if the parent is also a child object start the loop to find all the child objects
				$i = 1; //set the counter
				$final = false; //switch to turn off the loop
				while (!$final) {
					$parent[$i] = $this->ci->breadcrumbs_model->get_page($parent[$i-1]->parent_id); //get the parent from the model
					if ($parent[$i]->parent_id == ''){$final=true;} //if there are no more parents stop the loop
					$i++;
				}
			}
			krsort($parent); //reverse the array
			foreach ($parent as $breadcrumbItem) {
				if (isset($breadcrumbItem->view)){
					$breadcrumb .= anchor($breadcrumbItem->controller."/".$breadcrumbItem->view,$breadcrumbItem->title) ." > ";
				}
				else {
					$breadcrumb .= anchor($breadcrumbItem->controller,$breadcrumbItem->title) ." > ";
				}
			}
			if (isset($page->view)){
				$breadcrumb .= anchor($page->controller."/".$page->view,$page->title); //attach the page title
			}
			else {
				$breadcrumb .= anchor($page->controller,$page->title); //attach the page title
			}
		}
		return $breadcrumb;
	}
}