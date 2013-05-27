<?php 

	if (!defined('BASEPATH')) die();

	class Conf_support extends SF_Controller {
	
		public function __construct() {
			parent::__construct();
		}
		
		public function index(){
			$this->header( "Configure Support" );
			$this->navbar();
		}
		
	}
	
?>