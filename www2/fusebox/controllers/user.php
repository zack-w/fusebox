<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('BASEPATH')) die();

class User extends SF_Controller {

	public function index()
	{
		$this->header("PacketCat - Username");
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
			//$this->footer();
		}
	}
	
	public function logout()
	{
		$logout = $this->ion_auth->logout();
		$this->session->set_flashdata('messageSuccess', $this->ion_auth->messages());
		redirect('user/login', 'refresh');
	}
	

	public function register()
	{
		
	}

	/**public function register() {
	
		if ($this->ion_auth->logged_in()) { redirect("/"); }
	
		//$this->load->library('recaptcha');
		//$this->lang->load('recaptcha');
	
		$this->form_validation->set_rules('username', "Username", 'required|xss_clean|min_length[4]|max_length[12]');
		$this->form_validation->set_rules('email', "Email", 'required|valid_email');
		$this->form_validation->set_rules('password', "Password", 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', "Confirm Password", 'required');
		//$this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
		
		if ($this->form_validation->run() && $this->ion_auth->register($this->input->post("username"), $this->input->post("password"), $this->input->post("email"))) {
		
			$this->load->library('postmark');
			$this->postmark->to($this->input->post("email"));
			$this->postmark->tag("PacketCat");
			$this->postmark->subject("PacketCat Account Creation");
			$mailData["user"] = $this->input->post("username");
			$this->postmark->message_plain($this->load->view("email/welcome", $mailData, true));
			$this->postmark->send();
		
			$this->message->success("Registration Successful! An email was sent to your address and you may now login.");
			redirect('user/login', 'refresh');
		} else {
			$error = "";
			if (validation_errors()) { $error = validation_errors(); }
			if ($this->ion_auth->errors()) { $error .= "<br>".$this->ion_auth->errors(); }
			$this->message->error($error);
			$this->header("PacketCat - Register");
			$this->data["recaptcha"] = $this->recaptcha->get_html();
			$this->view("v_register");
			$this->footer();
		}
	}
	
	function check_captcha($val) {
	  	if ($this->recaptcha->check_answer($this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $val)) {
	    	return TRUE;
	  	}
		
	    $this->form_validation->set_message('check_captcha', "Your captcha response was incorrect. Please retry!");
	    return FALSE;
	}**/
   
}

?>