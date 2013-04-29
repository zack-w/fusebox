<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends SF_Controller {

	public function index()
	{
		if( !$this->ion_auth->logged_in() )
			redirect( "/" );
		
		$this->header( "Dashboard" );
		$this->navbar();
	}
	
}