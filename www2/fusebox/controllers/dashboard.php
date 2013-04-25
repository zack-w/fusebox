<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends SF_Controller {

	public function index()
	{
		if($this->ion_auth->logged_in() != true) {
			redirect("user/login", "refresh");
		}
		
		$this->header( "Dashboard" );
		$this->load->view( "includes/navbar" );
	}
	
}