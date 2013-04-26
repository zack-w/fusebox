<?php

	class Support_status
	{
		public $Items;
		
		public $STATUS_OPENED = 1;
		public $STATUS_CLIENT_REPLY = 2;
		public $STATUS_STAFF_REPLY = 1;
		public $STATUS_CLOSED = 4;
		
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
			$Item = $this->Items[ $StatusID ];
			return $Item;
		}
		
		public function GetButton( $StatusID )
		{
			$Status = $this->GetStatus( $StatusID );
			$StatusText = $Status [ "Text" ];
		
			if( $this->IsNewlyOpened( $StatusID ) )
				return "<span class='label label-success'>{$StatusText}</span>";
			elseif( $this->IsClientReply( $StatusID ) )
				return "<span class='label label-info'>{$StatusText}</span>";
			elseif( $this->IsStaffReply( $StatusID ) )
				return "<span class='label label-important'>{$StatusText}</span>";
			elseif( $this->IsClosed( $StatusID ) )
				return "<span class='label label-inverse'>{$StatusText}</span>";
			else
				return "<span class='label'>{$StatusText}</span>";
		}
		
		public function IsNewlyOpened( $StatusID ) { return $StatusID == 1; }
		public function IsClientReply( $StatusID ) { return $StatusID == 2; }
		public function IsStaffReply( $StatusID ) { return $StatusID == 3; }
		public function IsClosed( $StatusID ) { return $StatusID == 4; }
		
		/*
			TODO - If a status is deleted, make it so that it calculates the new status
		*/
		
		public function DeleteStatus( $ID )
		{
			if( $ID > 0 && 5 > $ID ) return; // You cannot delete statuses 1 - 4.. they are used by the core
		
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