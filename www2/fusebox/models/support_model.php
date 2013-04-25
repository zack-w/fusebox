<?php
class Support_model extends CI_Model {

	function __construct() {
		parent::__construct();
		
		$this->load->library("ion_auth");
		$this->user = $this->ion_auth->user()->row();
	}
	
	function GetRecentTickets( $UserID, $Start, $Limit ) {
		$UserID = intval( $UserID ); $Start = intval( $Start ); $Limit = intval( $Limit );
		
		$Query = "SELECT * FROM `support_tickets` ";
		
		if( $UserID != null )
		{
			$Query .= "WHERE `UID` = {$UserID} ";
		}
		
		$Query .= "ORDER BY `Date` DESC ";
		$Query .= "LIMIT " . $Start . ", " . $Limit;
		
		return $this->db->query( $Query )->result_array();
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
	
	function PostTicket( $User, $Subject, $Body, $Priority ) {
		$Insert = array(
			"UID" => intval( $User ),
			"Subject" => $this->db->escape( $Subject ),
			"Date" => time(),
			"Priority" => $Priority,
			"Status" => 1,
		);
		
		$this->db->insert( "support_tickets", $Insert );
		
		$InsertID = $this->db->insert_id();
		$this->PostTicketReply( $InsertID, $User, $Body );
		
		return $InsertID;
	}
	
	function PostTicketReply( $TID, $User, $Body ) {
		$Insert = array(
			"TID" => intval( $TID ),
			"UID" => intval( $User ),
			"Content" => $this->db->escape( $Body ),
			"Date" => time(),
		);
		
		$this->db->insert( "support_tickets_replies", $Insert );
	}
	
	function UpdateTicketStatus( $TID, $StatusID ) {
		$TID = intval( $TID );
		$StatusID = intval( $StatusID );
	
		$this->db->query( "UPDATE `support_tickets` SET `Status` = {$StatusID} WHERE `ID` = {$TID};" );
	}
	
}