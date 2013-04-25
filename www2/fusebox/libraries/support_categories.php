<?php

	class Support_categories
	{
		public $Items;
		
		public function __construct()
		{
			$Items = array();
			$this->Grab();
		}
		
		private function Grab()
		{
			$Query = get_instance()->db->query( "SELECT * FROM `support_tickets_categories`;" );
			
			foreach( $Query->result() as $Row )
			{
				$this->Items[ intval( $Row->ID ) ] = $Row->Text;
			}
		}
		
		public function GetCategory( $CatID )
		{
			$Item = $this->Items[ intval( $CatID  )];
			return $Item;
		}
		
		public function DeleteCategory( $CatID, $Repalcement )
		{
			get_instance()->db->query( "UPDATE `support_tickets` SET `Category` = {$Replacement} WHERE `Category` = {$CatID};" );
			get_instance()->db->query( "DELETE FROM `support_tickets_categories` WHERE `ID` = {$CatID};" );
		}
		
		public function AddCategory( $Text )
		{
			$Text = get_instance()->db->escape( $Text );
			get_instance()->db->query( "INSERT INTO `support_tickets_categories` VALUES ( NULL, {$Text} );" );
		}
		
		public function EditCategory( $ID, $Text )
		{
			$ID = intval( $ID );
			$Text = get_instance()->db->escape( $Text );
			
			get_instance()->db->query( "UPDATE `support_tickets_categories` SET `Text` = {$Text} WHERE `ID` = {$ID};" );
		}
	}

?>