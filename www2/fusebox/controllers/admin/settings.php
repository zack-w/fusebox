<?php 

	if ( !defined('BASEPATH') ) die();
	
	class Settings extends SF_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		public function index( $SettingCat = 1 ) {
			$this->header( "Settings" );
			$this->navbar();
			
			if( isset( $_GET["cat"] ) && intval( $_GET["cat"] ) != null )
				$SettingCat = intval( $_GET["cat"] );
			
			$Settings = array();
			
			foreach( $this->settings_model->Settings as $SettingID => $Setting )
			{
				if( $Setting->Category == $SettingCat )
					array_push( $Settings, $Setting );
			}
			
			$this->data[ "CurSettingCat" ] = $this->settings_model->SettingCategories[ $SettingCat ];
			$this->data[ "SettingCats" ] = $this->settings_model->SettingCategories;
			$this->data[ "Settings" ] = $Settings;
			
			$this->view( "admin/settings" );
		}
		
		public function ajax_updatesetting()
		{
			// TODO :: Make sure they are allowed to change the setting!
			
			if( !isset( $_GET[ "key" ] ) || !isset( $_GET[ "value" ] ) )
				die( "error" );
			
			$Setting = $this->settings_model->Get( $_GET[ "key" ] );
			$Value = $_GET[ "value" ];
			
			if( $Setting == null )
				die( "error" );
			
			if( $Setting->Type == 1 && ($Value != "true" && $Value != "false") )
				die( "error" );
				
			if( $Setting->Type == 3 && intval($Value) == null )
				die( "error" );
			
			$this->settings_model->UpdateSettingValue( $_GET[ "key" ], $Value );
			die( "success" );
		}
		
	}
	
?>