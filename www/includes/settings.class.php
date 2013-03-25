<?php

	class Settings {

		function __construct() {
			//Do stuff here.
		}

		public function get($key, $getArr = false) {
			global $DB;
			$key = $DB->escape($key);
			if ($data = $DB->queryArray("SELECT * FROM system_settings WHERE `key`='".$key."'",false,true)) {
				if($getArr)
					return $data[0]['value'];
				else
				{
					if(strpos($data[0]['value'],"true") === false)
					{
						//Not Found, try false
						if(strpos($data[0]['value'],"false") === false)
							return $data[0]['value'];
						else
							return false;
					}
					else
					{
						return true;
					}
					
				}
			} else {
				return "error: setting not found";
			}
		}
		
		//TODO: fix this
		public function set($key, $value) {
			global $DB;
			$key = $DB->escape($key);
			$value = $DB->escape($value);
			if ($DB->queryRow("SELECT * FROM system_settings WHERE uid='".$this->uid."'' AND okey='".$key."'")) {
				$DB->query("UPDATE system_settings SET ovalue='".$value."' WHERE uid='".$this->uid."'' AND okey='".$key."'");
			} else {
				$DB->query("INSERT INTO system_settings (uid, okey, ovalue) VALUES ('".$this->uid."', '".$key."', '".$value."')");
			}
		}	
	}