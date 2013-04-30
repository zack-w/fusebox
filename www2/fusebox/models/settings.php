<?php
	
	/*
		Setting Types
		-------------------
		1	TEXT
		2	BOOLEAN
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
	
	class Settings extends CI_Model {
		
		public $SettingCategories = array();
		public $Settings = array();
		
		function __construct(){
			parent::__construct();
			$this->Grab();
		}
		
		private function Grab()
		{
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings`;" );
			
			foreach( $Query->result() as $Row )
			{
				$Setting = new Setting( $Row->Key, $Row->Value, $Row->Type, $Row->Category, $Row->Options );
				$this->Settings[ $Row->Key ] = $Setting;
			}
			
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings_categories`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->Settings[ intval( $Row->ID ) ] = $Row->Name;
			}
		}
		
		public function Get( $Key )
		{
			return $this->Settings[ $Key ];
		}
		
	}
