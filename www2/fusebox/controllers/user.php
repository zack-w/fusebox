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

			$SignatureEnabled = $this->settings_model->get("users_allow_signature_bb")->Value;
			$this->data['SignatureEnabled'] = ($SignatureEnabled == "enabled" || ($this->ion_auth->is_staff($this->user->id) && $SignatureEnabled == "staff"));
			
			$this->data['state_array'] = $this->states->states;

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
			$this->load->helper("bbcode");
			
			$CanChangeName = $this->settings_model->get("users_allow_namechange")->Value;
			$data = array();
			
			if( $CanChangeName == "firstname" || $CanChangeName == "both" )
				$data[ 'first_name' ] = $this->input->post('firstname');
			
			if( $CanChangeName == "lastname" || $CanChangeName == "both" )
				$data[ 'last_name' ] = $this->input->post('lastname');
			
			$this->form_validation->set_rules('company', 'Company', 'xss_clean|strip_tags|trim|max_length[30]|ctype_alnum');
			$this->form_validation->set_rules('address1', 'Address', 'required|xss_clean|strip_tags|trim|max_length[30]|ctype_alnum');
			$this->form_validation->set_rules('address2', 'Address 2', 'xss_clean|strip_tags|trim|max_length[30]|ctype_alnum');
			$this->form_validation->set_rules('city', 'City', 'required|xss_clean|strip_tags|trim|max_length[30]|ctype_alnum');
			$this->form_validation->set_rules('state', 'State', 'required|xss_clean|strip_tags|trim|max_length[2]|ctype_alnum');
			$this->form_validation->set_rules('zip', 'Zip', 'required|xss_clean|strip_tags|trim|max_length[5]|ctype_alnum');
			$this->form_validation->set_rules('country', 'Country', 'required|xss_clean|strip_tags|trim|max_length[30]');
			$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean|strip_tags|trim|max_length[10]|ctype_alnum');
			$this->form_validation->set_rules('signature', 'Signature', 'xss_clean|strip_tags|trim|max_length[300]');
			
			if ( $this->form_validation->run() == false ) {
				$this->index(); // There were errors, so load the index
				return;
			}
			
			$data[ 'company' ] = $this->input->post('company');
			$data[ 'address1' ] = $this->input->post('address1');
			$data[ 'address2' ] = $this->input->post('address2');
			$data[ 'city' ] = $this->input->post('city');
			$data[ 'state' ] = $this->input->post('state');
			$data[ 'zip' ] = $this->input->post('zip');
			$data[ 'country' ] = $this->input->post('country');
			$data[ 'phone' ] = $this->input->post('phone');
			
			$SignatureEnabled = $this->settings_model->get("users_allow_signature_bb")->Value;
			if ($SignatureEnabled == "enabled" || ($this->ion_auth->is_staff() && $SignatureEnabled == "staff"));
				$data[ 'signature' ] = $this->input->post('signature');
			
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', "Password", 'required|min_length[6]|max_length[12]|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', "Confirm Password", 'required');
				
				if ( $this->form_validation->run() != false ) {
					$data['password'] = $this->input->post('password');
				}
			}
			
			$this->ion_auth->update( $this->user->id, $data );
			redirect_raw( "user" );
		}

}