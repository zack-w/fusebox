<?php 

	if (!defined('BASEPATH')) die();

	class Conf_usergroups extends SF_Controller {
	
		public function __construct() {
			parent::__construct();
		}
		
		// TODO :: Permissions
		public function index() {
			$this->header( "Configure Usergroups" );
			$this->navbar();
			
			$this->data[ "Usergroups" ] = $this->usergroup_model->GetAll();
			
			$this->view( "admin/configure/usergroups" );
			$this->footer();
		}
		
		public function edit() {
			$CurUsergroup = $this->input->get( 'id' );
			if( empty( $CurUsergroup ) ) $this->index();
		
			$this->header( "Configure Usergroups" );
			$this->navbar();
			
			$CurCat = $this->input->get( 'cid' );
			if( $CurCat ) $this->data[ "CurCat" ] = 1;
			
			$this->data[ "CurUsergroup" ] = $CurUsergroup;
			$this->data[ "CurCat" ] = $CurCat;
			
			$this->view( "admin/configure/usergroups_edit" );
			$this->footer();
		}
		
	}
	
?>