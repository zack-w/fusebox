<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Nav
	{
		public $Locations; // An array of all tab elements
		
		public function __construct() {
			$this->Locations = array();
		}
		
		public function AddToNav( $PageID, $IconClass, $AdminRequired = false )
		{
			array_push( $this->Locations, array(
				"PageID" => $PageID,
				"Icon" => $IconClass,
				"LangText" => "base_page_" . $PageID,
				"AdminOnly" => $AdminRequired,
			) );
		}
	}

?>