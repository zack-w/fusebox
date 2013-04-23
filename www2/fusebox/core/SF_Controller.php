<?php
class SF_Controller extends CI_Controller
{
   function __construct()
   {
      parent::__construct();

      //Setup Database
      $this->load->database();

      //Load helpers
      $this->load->helper('url');
      $this->load->helper('language');

      //Load classes
      $this->lang->load('base');

      //Load Models
      $this->load->model("Settings");
      
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
