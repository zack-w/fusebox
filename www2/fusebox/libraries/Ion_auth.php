<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ion_auth
{
	protected $status;
	public $_extra_where = array();
	public $_extra_set = array();

	public function __construct() {
		$this->load->config('ion_auth', TRUE);
		$this->load->library('email');
		$this->load->helper('cookie');
		
		// Load the session, CI2 as a library, CI3 uses it as a driver
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->load->library('session');
		}
		else
		{
			$this->load->driver('session');
		}

		// Load IonAuth MongoDB model if it's set to use MongoDB,
		// We assign the model object to "ion_auth_model" variable.
		$this->config->item('use_mongodb', 'ion_auth') ?
			$this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
			$this->load->model('ion_auth_model');
		
		//auto-login the user if they are remembered
		if (!$this->logged_in() && get_cookie('identity') && get_cookie('remember_code'))
			$this->ion_auth_model->login_remembered_user();

		$email_config = $this->config->item('email_config', 'ion_auth');

		if ($this->config->item('use_ci_email', 'ion_auth') && isset($email_config) && is_array($email_config))
			$this->email->initialize($email_config);

		$this->ion_auth_model->trigger_events('library_constructor');
	}

	public function __call($method, $arguments) {
		if (!method_exists( $this->ion_auth_model, $method) )
		{
			throw new Exception('Undefined method Ion_auth::' . $method . '() called');
		}

		return call_user_func_array( array($this->ion_auth_model, $method), $arguments);
	}
	
	public function __get($var) {
		return get_instance()->$var;
	}

	public function forgotten_password($identity) {
		if ( $this->ion_auth_model->forgotten_password($identity) )	//changed
		{
			// Get user information
			$user = $this->where($this->config->item('identity', 'ion_auth'), $identity)->users()->row();  //changed to get_user_by_identity from email

			if ($user)
			{
				$data = array(
					'identity'		=> $user->{$this->config->item('identity', 'ion_auth')},
					'forgotten_password_code' => $user->forgotten_password_code
				);

				if(!$this->config->item('use_ci_email', 'ion_auth'))
				{
					$this->set_message('forgot_password_successful');
					return $data;
				}
				else
				{
					$message = $this->load->view($this->config->item('email_templates', 'ion_auth').$this->config->item('email_forgot_password', 'ion_auth'), $data, true);
					$this->email->clear();
					$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
					$this->email->to($user->email);
					$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_forgotten_password_subject'));
					$this->email->message($message);

					if ($this->email->send())
					{
						$this->set_message('forgot_password_successful');
						return TRUE;
					}
					else
					{
						$this->set_error('forgot_password_unsuccessful');
						return FALSE;
					}
				}
			}
			else
			{
				$this->set_error('forgot_password_unsuccessful');
				return FALSE;
			}
		}
		else
		{
			$this->set_error('forgot_password_unsuccessful');
			return FALSE;
		}
	}

	public function forgotten_password_complete($code) {
		$this->ion_auth_model->trigger_events('pre_password_change');

		$identity = $this->config->item('identity', 'ion_auth');
		$profile  = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!$profile)
		{
			$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}

		$new_password = $this->ion_auth_model->forgotten_password_complete($code, $profile->salt);

		if ($new_password)
		{
			$data = array(
				'identity'	  => $profile->{$identity},
				'new_password' => $new_password
			);
			if(!$this->config->item('use_ci_email', 'ion_auth'))
			{
				$this->set_message('password_change_successful');
				$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return $data;
			}
			else
			{
				$message = $this->load->view($this->config->item('email_templates', 'ion_auth').$this->config->item('email_forgot_password_complete', 'ion_auth'), $data, true);

				$this->email->clear();
				$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
				$this->email->to($profile->email);
				$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_new_password_subject'));
				$this->email->message($message);

				if ($this->email->send())
				{
					$this->set_message('password_change_successful');
					$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_successful'));
					return TRUE;
				}
				else
				{
					$this->set_error('password_change_unsuccessful');
					$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
					return FALSE;
				}

			}
		}

		$this->ion_auth_model->trigger_events(array('post_password_change', 'password_change_unsuccessful'));
		return FALSE;
	}

	public function forgotten_password_check($code) {
		$profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

		if (!is_object($profile))
		{
			$this->set_error('password_change_unsuccessful');
			return FALSE;
		}
		else
		{
			if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {
				//Make sure it isn't expired
				$expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
				if (time() - $profile->forgotten_password_time > $expiration) {
					//it has expired
					$this->clear_forgotten_password_code($code);
					$this->set_error('password_change_unsuccessful');
					return FALSE;
				}
			}
			return $profile;
		}
	}

	public function register($password, $email, $additional_data = array()) {
		$this->ion_auth_model->trigger_events('pre_account_creation');
		
		$email_activation = $this->config->item('email_activation', 'ion_auth');

		if (!$email_activation)
		{
			$id = $this->ion_auth_model->register($password, $email, $additional_data);
			if ($id !== FALSE)
			{
				$this->set_message('account_creation_successful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful'));
				return $id;
			}
			else
			{
				$this->set_error('account_creation_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}
		}
		else
		{
			$id = $this->ion_auth_model->register($password, $email, $additional_data);

			if (!$id)
			{
				$this->set_error('account_creation_unsuccessful');
				return FALSE;
			}

			$deactivate = $this->ion_auth_model->deactivate($id);

			if (!$deactivate)
			{
				$this->set_error('deactivate_unsuccessful');
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful'));
				return FALSE;
			}

			$activation_code = $this->ion_auth_model->activation_code;
			$identity		  = $this->config->item('identity', 'ion_auth');
			$user				= $this->ion_auth_model->user($id)->row();

			$data = array(
				'identity'	=> $user->{$identity},
				'id'			=> $user->id,
				'email'		=> $email,
				'activation' => $activation_code,
			);
			
			if(!$this->config->item('use_ci_email', 'ion_auth'))
			{
				$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
				$this->set_message('activation_email_successful');
					return $data;
			}
			else
			{
				$message = $this->load->view($this->config->item('email_templates', 'ion_auth').$this->config->item('email_activate', 'ion_auth'), $data, true);
				
				$this->email->clear();
				$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
				$this->email->to($email);
				$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_activation_subject'));
				$this->email->message($message);

				if ($this->email->send() == TRUE)
				{
					$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_successful', 'activation_email_successful'));
					$this->set_message('activation_email_successful');
					return $id;
				}
			}

			$this->ion_auth_model->trigger_events(array('post_account_creation', 'post_account_creation_unsuccessful', 'activation_email_unsuccessful'));
			$this->set_error('activation_email_unsuccessful');
			return FALSE;
		}
	}

	public function logout() {
		$this->ion_auth_model->trigger_events('logout');

		$identity = $this->config->item('identity', 'ion_auth');
		$this->session->unset_userdata($identity);
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('user_id');

		//delete the remember me cookies if they exist
		if (get_cookie('identity'))
		{
			delete_cookie('identity');
		}
		if (get_cookie('remember_code'))
		{
			delete_cookie('remember_code');
		}

		//Destroy the session
		$this->session->sess_destroy();

		//Recreate the session
		if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}

		$this->set_message('logout_successful');
		return TRUE;
	}

	public function logged_in() {
		$this->ion_auth_model->trigger_events('logged_in');

		$identity = $this->config->item('identity', 'ion_auth');

		return (bool) $this->session->userdata($identity);
	}

	public function get_user_id() {
		$user_id = $this->session->userdata('user_id');
		if (!empty($user_id))
		{
			return $user_id;
		}
		return null;
	}

	public function is_staff( $id = false ) {
		return intval( $this->user->staff_acct ) == 1;
	}
	
	public function is_admin( $id = false ) {
		if( !isset( $this->user ) ) return false;
		return intval( $this->user->staff_acct ) == 1;
	}

}
