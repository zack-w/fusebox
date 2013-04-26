<?php 

if (!defined('BASEPATH')) die();

class Support extends SF_Controller {
	
	public function __construct() {
		parent::__construct();
		
		if( !$this->ion_auth->logged_in() )
			redirect( "/" );
		
		$this->load->model("support_model");
	}
	
	public function index( $HasNoActive = null ){
		$ViewAll = ( !empty( $HasNoActive ) ) ? ( $HasNoActive ) : ( $this->input->get("viewall") );
		$Page = $this->input->get("page");
		
		$ResultsPerPage = 25;
		$Results = $this->support_model->GetRecentTickets( $this->user->id, (empty($Page) ? (0) : (intval($Page))), $ResultsPerPage, !(empty( $ViewAll )) );
		
		$Tickets = $Results[ 0 ];
		$NumResults = $Results[ 1 ];
		$NumPages = ceil( $NumResults / $ResultsPerPage );
		
		if( $NumResults == 0 && $ViewAll == false ) // They have no open tickets, but may have closed tickets
		{
			$this->index( true );
		} else {
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
			$this->data[ "ViewingAllTickets" ] = $ViewAll;
			
			if( !empty( $HasNoActive ) )
				$this->data[ "HasNoActive" ] = true;
			
			$this->view( "v_support" );
			$this->footer();
		}
	}
	
	public function ticket( $ID = null ) {
		$this->header("FuseBox - View Ticket");
		$this->load->view( "includes/navbar" );
		
		if( $this->support_model->TicketExists( $ID ) == false )
			redirect( "support" );
		
		$Ticket = $this->support_model->GetTicketByID( $ID );
		
		if( empty( $Ticket ) || $this->support_model->UserCanAccessTicket( $ID ) == false )
			return; // TODO :: Access Denied
		
		$Ticket[ "Username" ] = $this->ion_auth->user( $Ticket[ "UID" ] )->row()->username;
		
		$Replies = $this->support_model->GetTicketReplies( $ID );
		
		foreach ( $Replies as $ID => $Reply ) {
			$Replies[ $ID ][ "Username" ] = $this->ion_auth->user( $Reply[ "UID" ] )->row()->username;
		}

		$this->data[ "Ticket" ] = $Ticket;
		$this->data[ "Replies" ] = $Replies;
		
		$this->view("v_support_ticket");
		$this->footer();
	}
	
	public function ticket_create() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|strip_tags|trim|max_length[30]');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean|trim');
		$this->form_validation->set_rules('priority', 'Priority', 'required|numeric');
		$this->form_validation->set_rules('category', 'Category', 'required|numeric');
		
		if ( $this->form_validation->run() == false || intval( $this->input->post( "priority" ) == null ) ) {
			$this->index(); // There were errors, so load the index
			return;
		}
		
		$Title = $this->input->post("title");
		
		if( empty( $Title ) )
			$Title = "No title entered";
		
		$TicketID = $this->support_model->PostTicket( 
			$this->user->id,
			$Title,
			$this->input->post("message"),
			$this->input->post("priority"),
			$this->input->post("category")
		);
		
		$this->ticket( $TicketID );
	}
	
	public function toggletickets()
	{
		$ToChangeString = $this->input->get( "tickets" );
	
		foreach( explode( ",", $ToChangeString ) as $TicketID )
		{
			if( is_numeric( $TicketID ) )
			{
				if( $this->support_model->UserCanAccessTicket( $TicketID ) )
				{
					$Ticket = $this->support_model->GetTicketByID( $TicketID );
					
					if( !empty( $Ticket ) )
					{
						if( $Ticket[ "Status" ] == 4 ) {
							$this->support_model->UpdateTicketStatus( $TicketID, 1 ); // TODO :: SET CORRECT TICKET STATUS
						} else {
							$this->support_model->UpdateTicketStatus( $TicketID, 4 );
						}
					}
				}
			}
		}
	
		$this->index();
	}
	
	public function ticket_respond() {
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean|strip_tags|trim');
		
		if ( $this->form_validation->run() == false || $this->support_model->UserCanAccessTicket( $this->input->post( "ticket" ) ) == false ) {
			$this->ticket( $this->input->post( "ticket" ) ); // There were errors, so load the ticket again
			return;
		}
		
		if( $this->support_model->TicketExists( $this->input->post( "ticket" ) ) == false )
		{
			$this->ticket( $this->input->post( "ticket" ) ); // There were errors, so load the ticket again
			return;
		}
		
		$this->support_model->PostTicketReply( $this->input->post( "ticket" ), $this->user->id, $this->input->post( "message" ) );
		
		if( $this->input->post( "close" ) == "closed" )
		{
				$this->support_model->UpdateTicketStatus( $this->input->post( "ticket" ), 4 );
		}
		
		$this->ticket( $this->input->post( "ticket" ) );
	}
	
	public function ticket_close( $ID , $redirect = "support" ) {
		$this->support_model->UpdateTicketStatus( $ID, 4 ); // TODO :: Calculate the correct ticket status
		redirect( $redirect);
	}
	public function ticket_open( $ID , $redirect = "support") {
		$this->support_model->UpdateTicketStatus( $ID, 1 ); // TODO :: Calculate the correct ticket status
		redirect( $redirect );
	}
	
}

?>