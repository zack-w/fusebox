<?php 

if (!defined('BASEPATH')) die();

class Support extends SF_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("support_model");
	}
	
	public function index(){
		$Tickets = $this->support_model->GetRecentTickets( $this->user->id, 0, 25 );
		
		foreach( $Tickets as $TicketID => $Ticket )
		{
			$TicketReplies = $this->support_model->GetTicketReplies( $Ticket[ "ID" ] );
			$LastReply = end( $TicketReplies );
			
			$Tickets[ $TicketID ][ "NumReplies" ] = count( $TicketReplies );
			$Tickets[ $TicketID ][ "LastReply" ] = $LastReply[ "Date" ];
			$Tickets[ $TicketID ][ "LastReplyUser" ] = $this->ion_auth->user( $LastReply[ "UID" ] )->row();
		}
		
		$this->header( "Support" );
		$this->load->view( "includes/navbar" );
		$this->data[ "Tickets" ] = $Tickets;
		$this->view( "v_support" );
		$this->footer();
	}
	
	public function ticket( $ID = null ) {
		$this->header("FuseBox - View Ticket");
		$this->load->view( "includes/navbar" );
		
		if( empty( $ID ) ) redirect( "support" );;
		
		$Ticket = $this->support_model->GetTicketByID( $ID );
		
		if( empty( $Ticket ) || $this->support_model->UserCanAccessTicket( $ID ) == false )
			return; // TODO :: Access Denied
		
		$Ticket[ "Username" ] = $this->ion_auth->user( $Ticket[ "UID" ] )->row()->username;
		
		$Replies = $this->support_model->GetTicketReplies( $ID );
		
		foreach ( $Replies as $ID => $Reply ) {
			$Replies[ $ID ][ "Username" ] = $this->ion_auth->user($Reply[ "UID" ])->row()->username;
		}
		
		$this->data[ "Ticket" ] = $Ticket;
		$this->data[ "Replies" ] = $Replies;
		
		$this->view("v_support_ticket");
		$this->footer();
	}
	
	public function ticket_create() {
		$this->form_validation->set_rules('title', 'Title', 'required|xss_clean|strip_tags|trim');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean|strip_tags|trim');
		
		if ( $this->form_validation->run() == false || intval( $this->input->post( "priority" ) == null ) ) {
			$this->index(); // There were errors, so load the index
			return;
		}
		
		$TicketID = $this->support_model->PostTicket( 
			$this->user->id,
			$this->input->post("title"),
			$this->input->post("message"),
			$this->input->post("priority")
		);
		
		$this->ticket( $TicketID );
	}
	
	public function ticket_respond() {
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean|strip_tags|trim');
		
		if ( $this->form_validation->run() == false || $this->support_model->UserCanAccessTicket( $this->input->post( "ticket" ) ) == false ) {
			$this->ticket( $this->input->post( "ticket" ) ); // There were errors, so load the ticket again
			return;
		}
		
		$this->support_model->PostTicketReply( $this->input->post( "ticket" ), $this->user->id, $this->input->post( "message" ) );
		$this->ticket( $this->input->post( "ticket" ) );
	}
	
	public function ticket_close( $ID ) {
		$this->support_model->UpdateTicketStatus( $ID, 4 ); // TODO :: Calculate the correct ticket status
		redirect( "support" );
	}
	public function ticket_open( $ID ) {
		$this->support_model->UpdateTicketStatus( $ID, 1 ); // TODO :: Calculate the correct ticket status
		redirect( "support" );
	}
	
}

?>