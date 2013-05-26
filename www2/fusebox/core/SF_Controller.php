<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SF_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		//Setup Database
		$this->load->database();
		
		//Load Libraries
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('nav');
		$this->load->library('support_priorities');
		$this->load->library('support_status');
		$this->load->library('support_categories');
		
		//Load helpersr
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('language');
		$this->load->helper('bootstrap_helper');
		
		//Load classes
		$this->lang->load('base');
		$this->lang->load('auth');
		$this->lang->load('settings');
		
		//Load Models
		$this->load->model('Settings');
		
		$this->loginUser();
		$this->SecurityCheck();
		$this->loadNavElements();
	}
	
	private function SecurityCheck()
	{
		$PageType = $this->uri->segment( 1 );
	
		if( $PageType == "admin" && $this->ion_auth->is_staff() == false ) {
			redirect_raw("users/dashboard", "refresh");
		}elseif( $PageType == "users" && $this->ion_auth->is_staff() ) {
			redirect_raw("admin/dashboard", "refresh");
		}elseif( $PageType != "user" && $this->ion_auth->logged_in() == false ){
			redirect_raw("user/login", "refresh");
		}
	}
	
	private function loadNavElements()
	{
		$this->nav->AddToNav( "dashboard", "icon-home" );
		$this->nav->AddToNav( "support", "icon-comment" );
		$this->nav->AddToNav( "user", "icon-user", true );
	}
	
	private function loginUser()
	{
		$this->data["login"] = $this->ion_auth->logged_in();
		
		if ($this->data["login"]) {
			$this->data["user"] = $this->ion_auth->user()->row();
			$this->user = $this->ion_auth->user()->row();
		}
		
		$this->data["admin"] = $this->ion_auth->is_admin();
	}
	
	public function view($name, $pass = true) {
		if ($pass) {
			$this->load->view($name, $this->data);
		} else {
			$this->load->view($name);
		}
	}

	public function navbar() {
		$this->load->view("navbar");
	}
	
	public function header($title) {
		$this->data["title"] = $title . " : ".$this->Settings->Get("general_display_name")->Value;
		$this->data["general_display_name"] = $this->Settings->Get("general_display_name")->Value;

		$this->load->view("includes/header", $this->data);
	}
	
	public function footer() {
		
	}
}
