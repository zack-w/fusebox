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
			
			$CurCat = $this->input->get( 'cat' );
			if( empty( $CurCat ) ) $CurCat = 1;
			
			$this->data[ "UsergroupObj" ] = $this->usergroup_model->GetByID( $CurUsergroup );
			$this->data[ "CurUsergroup" ] = $CurUsergroup;
			$this->data[ "CurCat" ] = $CurCat;
			
			$this->view( "admin/configure/usergroups_edit" );
			$this->footer();
		}
		
		public function ajax_updateperm() {
			// TODO :: Make sure they are allowed to change the setting!
			
			if( !isset($_GET['usergroup']) || !isset($_GET['key']) || !isset($_GET['value']) )
				die( "error" );
				
			$Usergroup = $this->usergroup_model->GetByID( intval( $this->input->get('usergroup') ) );
			if( $Usergroup == false ) die( "error" );
			
			if( $_GET[ "key" ] == "name" ) {
				$NewName = $this->db->escape( $_GET[ "value" ] );
				get_instance()->db->query( "UPDATE `usergroups` SET `Name` = {$NewName} WHERE `ID` = {$Usergroup->ID};" );
				die( "success" );
			}
			
			if( $_GET[ "value" ] == "enable_cat" || $_GET[ "value" ] == "disable_cat" ) {
				$CatID = intval( $_GET['key'] );
				
				if( $_GET[ "value" ] == "enable_cat" ) {
					$Usergroup->AddTicketCat( $CatID );
				}else{
					$Usergroup->RemoveTicketCat( $CatID );
				}
				
				die( "success" );
			}
			
			$Permission = Permissions::GetByKey( $this->input->get('key') );
			if( $Permission == false ) die( "error" );
			
			if( intval( $_GET['value'] ) == 1 ) {
				$Usergroup->GivePermission( $Permission->ID );
			}else{
				$Usergroup->RemovePermission( $Permission->ID );
			}
			
			die( "success" );
		}
		
	}
	
?>