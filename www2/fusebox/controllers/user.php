<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if (!defined('BASEPATH')) die();
	
	class User extends SF_Controller {

		public function index()
		{
			if( !$this->ion_auth->logged_in() )
				redirect( "/" );
			
			$this->header( "UserCP" );
			$this->navbar();

			$this->data['users_allow_namechange'] = $this->Settings->get("users_allow_namechange")->Value;
			
			$this->load->view( "user/usercp" , $this->data);
			$this->footer();
		}
		
		public function forgot()
		{
			$this->form_validation->set_rules('email', 'Email', 'required');
			
			if ($this->form_validation->run()) {
				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
					redirect('/', 'refresh');
				} else {
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
				
				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
					redirect('/', 'refresh');
				} else {
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
			redirect('user/login', 'refresh');
		}

		public function update()
		{
			$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
			$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');

			if (isset($_POST) && !empty($_POST))
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				$data = array(
					'first_name' => $this->input->post('firstname'),
					'last_name'  => $this->input->post('lastname'),
				);

				//Update the groups user belongs to
				$groupData = $this->input->post('groups');

				if (isset($groupData) && !empty($groupData)) {

					$this->ion_auth->remove_from_group('', $id);

					foreach ($groupData as $grp) {
						$this->ion_auth->add_to_group($grp, $id);
					}

				}

				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
					$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

					$data['password'] = $this->input->post('password');
				}

				if ($this->form_validation->run() === TRUE)
				{
					$this->ion_auth->update($user->id, $data);

					//check to see if we are creating the user
					//redirect them back to the admin page
					$this->session->set_flashdata('message', "User Saved");
					redirect("auth", 'refresh');
				}
			}
		}
	   
	}

?>