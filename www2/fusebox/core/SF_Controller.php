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
      $this->load->library('form_validation');
      $this->load->library('message');

      //Load helpers
      $this->load->helper('url');
      $this->load->helper('language');
      $this->load->helper('bootstrap_helper');
      //Load classes
      $this->lang->load('base');
      $this->lang->load('auth');


      //Load Models
      $this->load->model('Settings');

      $this->data["login"] = $this->ion_auth->logged_in();
      if ($this->data["login"]) {
         $this->data["user"] = $this->ion_auth->user()->row();
         $this->user = $this->ion_auth->user()->row();
      }
      $this->data["admin"] = $this->ion_auth->is_admin();
      
      //Set our flashdata via the message library.
      $this->message->setData($this->data);
      
   }

   public function view($name, $data = true) {
		if ($data) {
			$this->load->view($name, $this->data);
		} else {
			$this->load->view($name);
		}
	}

   public function header($title) {
      $this->data["title"] = $title . " : ".$this->Settings->get("general_display_name");
      $this->data["general_display_name"] = $this->Settings->get("general_display_name");

      $this->load->view("includes/header", $this->data);
   }
}
