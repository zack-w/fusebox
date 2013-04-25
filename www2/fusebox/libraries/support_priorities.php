<?php

	class Support_Priorities
	{
		public static $Items;
		
		public function __construct()
		{
			$Items = array();
			$this->Grab();
		}
		
		private function Grab()
		{
			$Query = get_instance()->db->query( "SELECT * FROM `support_priorities`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->Items[ intval( $Row->ID ) ] = $Row->Text;
			}
		}
		
		public function DeletePriority( $ID )
		{
			$ID = get_instance()->db->escape( $ID );
			get_instance()->db->query( "DELETE FROM `support_priorities` WHERE `ID` = {$ID};" );
		}
		
		public function AddPriority( $Text )
		{
			$Text = get_instance()->db->escape( $Text );
			get_instance()->db->query( "INSERT INTO `support_priorities` VALUES ( NULL, '{$Text}' );" );
		}
		
		public function EditPriority( $ID, $Text )
		{
			$ID = get_instance()->db->escape( $ID );
			$Text = get_instance()->db->escape( $Text );
			
			get_instance()->db->query( "UPDATE `support_priorities` SET `Text` = '{$Text}' WHERE `ID` = {$ID};" );
		}
	}

?>