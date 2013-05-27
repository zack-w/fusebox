<?php
	
	/*
		Setting Types
		-------------------
		1	BOOLEAN
		2	TEXT
		3	INT
	*/
	
	class Setting {
		
		public $Key;
		public $Value;
		public $Type;
		public $Category;
		public $Options;
		
		function __construct( $Key, $Value, $Type, $Category, $Options ) {
			$this->Key = $Key;
			$this->Value = $Value;
			$this->Type = intval( $Type );
			$this->Category = intval( $Category );
			$this->Options = $Options;
			
			if( $this->Type == 1 )
				$this->Value = ( $this->Value == "true" )?( true ):( false );
			elseif( $this->Type == 3 )
				$this->Value = intval( $this->Value );
		}
		
		public function UpdateValue( $NewValue )
		{
			if( $this->Type == 1 )
				$NewValue = ( $NewValue == true )?( "true" ):( "false" );
				
			$NewValue = $this->db->escape( $NewValue );
			$this->db->query( "UPDATE `system_settings` SET `value` = {$NewValue} WHERE `key` = " . ($this->Key) . ";" );
		}
		
		public function GetText( $Special ) // eg. title or desc
		{
			return lang( "setting_" . $this->Key . "_{$Special}" );
		}
		
	}
	
	class Settings_model extends CI_Model {
		
		public $Grabbed = false;
		public $SettingCategories = array();
		public $Settings = array();
		
		function __construct(){
			parent::__construct();
		}
		
		public function Grab() {
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings`;" );
			
			foreach( $Query->result() as $Row )
			{
				$Setting = new Setting( $Row->Key, $Row->Value, $Row->Type, $Row->Category, $Row->Options );
				$this->settings_model->Settings[ $Row->Key ] = $Setting;
			}
			
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings_categories`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->settings_model->Settings[ intval( $Row->ID ) ] = $Row->Name;
			}
			
			$this->settings_model->Grabbed = true;
		}
		
		public function Get( $Key ) {
			if( $this->settings_model->Grabbed == false )
				$this->settings_model->Grab();
			
			return $this->settings_model->Settings[ $Key ];
		}
		
	}
	
?>
