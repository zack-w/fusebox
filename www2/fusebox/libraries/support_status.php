<?php

	class Support_status
	{
		public static $Items;
		
		public function __construct()
		{
			$Items = array();
			$this->Grab();
		}
		
		private function Grab()
		{
			$Query = get_instance()->db->query( "SELECT * FROM `support_tickets_status`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->Items[ intval( $Row->ID ) ] = array( "Text" => $Row->Status, "Color" => $Row->Color );
			}
		}
		
		public function GetStatus( $StatusID )
		{
			return $this->Items[ $StatusID ] or "Unknown";
		}
		
		public function IsClosed( $StatusID ) // TODO :: GET FROM DB
		{
			if( $this->GetStatus( $StatusID ) == "Closed" )
			{
				return true;
			}else{
				return false;
			}
		}
		
		/*
			TODO - If a status is deleted, make it so that it calculates the new status
		*/
		
		public function DeleteStatus( $ID )
		{
			$ID = get_instance()->db->escape( $ID );
			get_instance()->db->query( "DELETE FROM `support_tickets_status` WHERE `ID` = {$ID};" );
		}
		
		public function AddStatus( $Text, $Color )
		{
			$Text = get_instance()->db->escape( $Text );
			get_instance()->db->query( "INSERT INTO `support_tickets_status` VALUES ( NULL, '{$Text}', '{$Color}' );" );
		}
		
		public function EditStatus( $ID, $Text, $Color )
		{
			$ID = get_instance()->db->escape( $ID );
			$Text = get_instance()->db->escape( $Text );
			$Color = get_instance()->db->escape( $Color );
			
			get_instance()->db->query( "UPDATE `support_tickets_status` SET `Status` = '{$Text}', `Color` = '{$Color}' WHERE `ID` = {$ID};" );
		}
	}

?>