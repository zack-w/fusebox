<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if (!defined('BASEPATH')) die();

	class User extends SF_Controller {

		public function index()
		{
			$this->header("FuseBox - Username");
			$this->navbar();
			
			$this->view("user");
			
			$this->footer();
		}
		
		public function login() 
		{	
			$this->form_validation->set_rules('identity', 'Identity', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
		
			if ($this->form_validation->run()) {
				$remember = (bool) $this->input->post('remember');
				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
					$this->message->success($this->ion_auth->messages());
					redirect('/', 'refresh');
				} else {
					$this->message->error(validation_errors()."<br>".$this->ion_auth->errors());
					redirect('user/login', 'refresh');
				}
			} else {
				$this->header(lang("base_page_login"));
				$this->view("login");
			}
		}
		
		public function logout()
		{
			$logout = $this->ion_auth->logout();
			$this->session->set_flashdata('messageSuccess', $this->ion_auth->messages());
			redirect('user/login', 'refresh');
		}
	   
	}

?>