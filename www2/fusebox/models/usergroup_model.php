<?php

	class Usergroup {
		
		public $ID;
		public $Name;
		private $TicketCats;
		private $Flags;
		
		public function CanAccessTicket( $TicketID ) {
			
		}
		
	}

	class Usergroup_model extends CI_Model {
		
		public $Grabbed = false;
		public $Objects = array();
		
	}

?>