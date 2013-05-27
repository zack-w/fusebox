<?php
	
	/*
		Setting Types
		-------------------
		1	BOOLEAN
		2	TEXT
		3	INT
		4	DROPDOWN
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
		
		public function GetText( $Special ) { // e.g. title or desc
			return lang( "setting_" . $this->Key . "_{$Special}" );
		}
		
		public function HTML_Form( $Key, $Type, $Value, $Name, $Options = "" ) {
			if( $Type == 1 ) {
				$SelectOne = ( $Value ) ? ( "selected=selected" ) : ( "" );
				$SelectTwo = ( !$Value ) ? ( "selected=selected" ) : ( "" );
				
				return "
					<select onchange='onSettingUpdated( this, \"{$Key}\", \"{$Name}\" );'>
						<option value='true' {$SelectOne}>Yes</option>
						<option value='false' {$SelectTwo}>No</option>
					</select>
				";
			}elseif( $Type == 2 ) {
				return "<input onblur='onSettingUpdated( this, \"{$Key}\", \"{$Name}\" );' type='text' value='{$Value}' />";
			}elseif( $Type == 3 ) {
				return "<input onblur='onSettingUpdated( this, \"{$Key}\", \"{$Name}\" );' type='number' value='{$Value}' />";
			}elseif( $Type == 4 ) {
				$Return = "<select onchange='onSettingUpdated( this, \"{$Key}\", \"{$Name}\" );'>";
				
				foreach( explode( ";", $Options ) as $Option ) {
					if( isset( $Option ) && !empty( $Option ) ) {
						$Selected = ( $Value == $Option )?( "selected=selected" ):( "" );
						$OptionLang = lang( "setting_{$Key}_option_{$Option}" );
						$Return .= "<option value='{$Option}' {$Selected}>{$OptionLang}</option>";
					}
				}
				
				return $Return . "</select>";
			}
		}
	}
	
	class Settings_model extends CI_Model {
		
		public $Grabbed = false;
		public $SettingCategories = array();
		public $Settings = array();
		
		function __construct(){
			parent::__construct();
		}
		
		public function UpdateSettingValue( $Key, $Value ) {
			if( $this->settings_model->Get( $Key )->Type == 1 ) {
				if( $Value == "false" || $Value == false )
					$Value = "false";
				else
					$Value = "true";
			}
			
			$Value = $this->db->escape( $Value );
			$Key = $this->db->escape( $Key );
			
			$this->db->query( "UPDATE `system_settings` SET `value` = {$Value} WHERE `Key` = " . ($Key) . ";" );
		}
		
		public function Grab() {
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings`;" );
			
			// Load all settings and their values give them a Setting object then put into Settings
			foreach( $Query->result() as $Row )
			{
				$Setting = new Setting( $Row->Key, $Row->Value, $Row->Type, $Row->Category, $Row->Options );
				$this->settings_model->Settings[ $Row->Key ] = $Setting;
			}
			
			// Load all categories, and put the name into $SettingCategories
			$Query = get_instance()->db->query( "SELECT * FROM `system_settings_categories`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->settings_model->SettingCategories[ intval( $Row->ID ) ] = lang( "settingcategory_" . $Row->SysName . "_title" );
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
