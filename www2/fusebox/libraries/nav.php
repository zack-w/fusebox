<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Nav
	{
		public $Locations; // An array of all tab elements
		
		public function __construct() {
			$this->Locations = array();
		}
		
		public function Accessible( $PageID )
		{
			// TODO -- Check if they have the permission to access this page
			return true;
		}
		
		public function AddToNav( $PageID, $IconClass, $NoPrefix = false, $Permission = "" )
		{
			array_push( $this->Locations, array(
				"PageID" => $PageID,
				"NoPrefix" => $NoPrefix,
				"Icon" => $IconClass,
				"LangText" => "base_page_" . $PageID,
				"Permission" => $Permission,
			) );
		}
	}
	
?>