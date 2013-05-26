<?php
class Support_model extends CI_Model {

	function __construct() {
		parent::__construct();
		
		$this->load->library("ion_auth");
		$this->user = $this->ion_auth->user()->row();
	}
	
	function TicketExists( $TicketID )
	{
		$TicketID = intval( $TicketID );
	
		if(empty( $TicketID ) )
			return false;
	
		$Query = $this->db->query( "SELECT COUNT(*) FROM `support_tickets` WHERE `ID` = " . $TicketID . ";" );
		$Row = $Query->row_array();
		
		return (intval( $Row[ "COUNT(*)" ] > 0))?(true):(false);
	}
	
	function UserCanAccessTicket( $TicketID )
	{
		if( $this->ion_auth->is_admin() ) return true; // TODO :: Add permissions here
		
		$Ticket = $this->GetTicketByID( $TicketID );
		
		if( !empty( $Ticket ) )
		{
			if( intval( $Ticket[ "UID" ] ) == intval( $this->user->id ) )
				return true;
			else
				return false;
		}
		
		return false;
	}
	
	function GetRecentTickets( $UserID = 0, $Start, $Limit, $StatusFilter = 0, $CatFilter = 0 ) {
		$Start = intval( $Start ); $Limit = intval( $Limit );
		
		/*
			Two steps, first to check for the number of tickets
			Then to actually fetch the tickets where we incorporate limits
		*/
		
		$CountQuery = "SELECT COUNT(*) FROM `support_tickets` ";
		$SelectQuery = "SELECT * FROM `support_tickets` ";
		
		$Where = "";
		
		if( $UserID != 0 || $StatusFilter != 0 || $CatFilter != 0 ) {
			$Where .= "WHERE ";
			
			if( $UserID != 0 )
				$Where .= "UID = {$UserID} AND ";
			
			if( $StatusFilter != 0 )
				$Where .= "{$StatusFilter} & POW( 2, `Status` ) = POW( 2, `Status` ) AND ";
				
			if( $CatFilter != 0 )
				$Where .= "{$CatFilter} & POW( 2, `Category` ) = POW( 2, `Category` ) AND ";
				
			$Where .= "TRUE ";
		}
		
		$CountQuery .= $Where;
		$SelectQuery .= $Where;
		
		$SelectQuery .= "ORDER BY `Date` DESC ";
		$SelectQuery .= "LIMIT " . $Start . ", " . $Limit;
		
		$Tickets = $this->db->query( $SelectQuery )->result_array();
		$CountResp = $this->db->query( $CountQuery )->result_array();
		
		return array( $Tickets, intval( $CountResp[ 0 ][ "COUNT(*)" ] ) );
	}
	
	function GetTicketByID( $ID ) {
		$ID = intval( $ID );
		return $this->db->query( "SELECT * FROM `support_tickets` WHERE `ID` = {$ID};" )->row_array();
	}
	
	function GetReplyByID( $ID ) {
		$ID = intval( $ID );
		return $this->db->query( "SELECT * FROM `support_ticket_replies` WHERE `ID` = {$ID};" )->row_array();
	}
	
	function GetTicketReplies( $TID ) {
		$TID = intval( $TID );
		return $this->db->query( "SELECT * FROM `support_tickets_replies` WHERE `TID` = {$TID};" )->result_array();
	}
	
	function PostTicket( $User, $Subject, $Body, $Priority, $Category ) {
		$Insert = array(
			"UID" => intval( $User ),
			"Subject" => $Subject,
			"Date" => time(),
			"Priority" => $Priority,
			"Category" => $Category,
			"Status" => 1,
		);
		
		$this->db->insert( "support_tickets", $Insert );
		
		$InsertID = $this->db->insert_id();
		$this->PostTicketReply( $InsertID, $User, $Body );
		
		return $InsertID;
	}
	
	function PostTicketReply( $TID, $User, $Body ) {
		$Body = strip_tags( nl2br( $Body ), "<br>" );
		
		$Insert = array(
			"TID" => intval( $TID ),
			"UID" => intval( $User ),
			"Content" => $Body,
			"Date" => time(),
		);
		
		$this->db->insert( "support_tickets_replies", $Insert );
		// TODO :: UPDATE TICKET STATUS
	}
	
	function UpdateTicketStatus( $TID, $StatusID ) {
		$TID = intval( $TID );
		$StatusID = intval( $StatusID );
	
		$this->db->query( "UPDATE `support_tickets` SET `Status` = {$StatusID} WHERE `ID` = {$TID};" );
	}
	
}