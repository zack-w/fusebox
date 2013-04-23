<?php
class Settings extends CI_Model {

	private $cache = Array();

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get($key, $getArr = false)
    {
    	$this->load->helper('array');

		$key = $this->db->escape($key);

    	//Check cache first to save queries
    	if($data = element($key,$this->cache))
    	{
    		return $this->processReturn($data, $getArr);
    	}
		
		if ($data = $this->db->query("SELECT * FROM system_settings WHERE `key`=".$key))
		{
			$data = $data->result_array();
			return $this->processReturn($data, $getArr);
		} else {
			return "error: setting not found";
		}
	}

	private function processReturn($data, $getArr)
	{
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
	}
		
	//TODO: fix this
	public function set($key, $value)
	{
		global $DB;
		$key = $DB->escape($key);
		$value = $DB->escape($value);
		if ($DB->queryRow("SELECT * FROM system_settings WHERE uid='".$this->uid."'' AND okey='".$key."'"))
		{
			$DB->query("UPDATE system_settings SET ovalue='".$value."' WHERE uid='".$this->uid."'' AND okey='".$key."'");
		}
		else 
		{
			$DB->query("INSERT INTO system_settings (uid, okey, ovalue) VALUES ('".$this->uid."', '".$key."', '".$value."')");
		}
	}	

	public function getCache()
	{
		return $this->cache;
	}
}