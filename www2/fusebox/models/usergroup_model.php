<?php

	class Usergroup {
		
		public $ID = -1;
		public $Name = "";
		public $Description = "";
		public $TicketCats = -1;
		public $Flags = "";
		public $NumUsers = 0;
		public $Deleteable = true;
		
	}

	class Permission {
		
	}
	
	class PermissionCat {
		public $ID;
		public $Key;
	}
	
	class Permissions {
		
		public static $Grabbed = false;
		public static $Categories = array();
		public static $Permissions = array();
		
		static function Grab() {
			Permissions::$Grabbed = true;
			Permissions::$Categories = array();
			Permissions::$Permissions = array();
			
			$PermissionCats = get_instance()->db->query( "SELECT * FROM `permissions_categories`;" );
			$Permissions = get_instance()->db->query( "SELECT * FROM `permissions`;" );
			
			foreach( $PermissionCats->result() as $Row )
			{
				$PermCat = new PermissionCat();
				$PermCat->ID = $Row->ID;
				$PermCat->Key = $Row->Key;
				array_push( Permissions::$Categories, $PermCat );
			}
		}
		
		static function GetCategories() {
			if( Permissions::$Grabbed == false ) Permissions::Grab();
			return Permissions::$Categories;
		}
	}
	
	class Usergroup_model extends CI_Model {
		
		public $Grabbed = false;
		public $Objects = array();
		
		function GetAll() {
			if( $this->Grabbed == false ) $this->GrabAll();
			return $this->Objects;
		}
		
		function GrabAll() {
			$this->Objects = array();
			$this->Grabbed = true;
			
			$Query = $this->db->query( "SELECT * FROM `usergroups`;" );
			
			foreach( $Query->result() as $Row )
			{
				$Usergroup = new Usergroup();
				$Usergroup->ID = $Row->ID;
				$Usergroup->Name = $Row->Name;
				$Usergroup->Description = $Row->Description;
				$Usergroup->TicketCats = $Row->TicketCats;
				$Usergroup->Flags = $Row->Flags;
				$Usergroup->Deleteable = ( $Row->Deleteable == 1 );
				
				$Query2 = $this->db->query( "SELECT COUNT(*) FROM `users` WHERE `usergroup` = {$Row->ID};" );
				$Row = $Query2->row_array();
				$Usergroup->NumUsers = $Row[ "COUNT(*)" ];
				
				array_push( $this->Objects, $Usergroup );
			}
		}
		
	}

?>