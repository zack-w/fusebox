<?php

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard extends SF_Controller {

		public function index()
		{
			$this->header( "Dashboard" );
			$this->navbar();
		}
		
	}

?>