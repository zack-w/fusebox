<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class User extends SF_Controller {
		
	public function index()
	{
		if( !$this->ion_auth->logged_in() )
			redirect( "/" );
		
		$this->header( "UserCP" );
		$this->navbar();
		
		$CanChangeName = $this->settings_model->get("users_allow_namechange")->Value;
		$this->data['CanChangeFirstname'] = ($CanChangeName == "firstname" || $CanChangeName == "both");
		$this->data['CanChangeLastname'] = ($CanChangeName == "lastname" || $CanChangeName == "both");
		
		$this->data['CanChangeEmail'] = $this->settings_model->get("users_allow_emailchange")->Value;
		
		$this->load->view( "usercp" , $this->data);
		$this->footer();
	}
	
	public function forgot()
	{
		$this->form_validation->set_rules('email', 'Email', 'required');
		
		if ($this->form_validation->run())
		{
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				redirect('/', 'refresh');
			}
			else
			{
				$this->data[ "AccountLoginError" ] = true;
			}
		}
		
		$this->header(lang("base_page_login"));
		$this->view("auth/forgot_password");
	}
		
	public function login() 
	{	
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
			
		if ($this->form_validation->run()) {
			$remember = (bool) $this->input->post('remember');
			
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				redirect('/', 'refresh');
			}
			else
			{
				$this->data[ "AccountLoginError" ] = true;
			}
		}
			
		$this->data[ "email_fill" ] = $this->input->post('identity') or "";
		$this->header(lang("base_page_login"));
		$this->view("login");
	}
		
	public function logout()
	{
		$logout = $this->ion_auth->logout();
		$this->session->set_flashdata('messageSuccess', $this->ion_auth->messages());
		redirect_raw('user/login', 'refresh');
	}
		
	public function update()
	{
		$CanChangeName = $this->settings_model->get("users_allow_namechange")->Value;
			
		$data = array();
			
		if( $CanChangeName == "firstname" || $CanChangeName == "both" )
			$data[ 'first_name' ] = $this->input->post('firstname');
		
		if( $CanChangeName == "lastname" || $CanChangeName == "both" )
			$data[ 'last_name' ] = $this->input->post('lastname');
		
		//update the password if it was posted
		if ($this->input->post('password'))
		{
			$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

			$data['password'] = $this->input->post('password');
		}
			
		$this->ion_auth->update( $this->user->id, $data );
		$this->session->set_flashdata('message', "User Saved");
		redirect_raw( "user" );
	}
	  
}