<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends SF_Controller {
	public function index()
	{
		$this->header("Dashboard");
		if($this->ion_auth->logged_in())
		{
			$this->load->view("includes/navbar");
			//redirect("dashboard","refresh");
		}
		else
		{
			//redirect("user/login", "refresh");
		}
		
	}
}