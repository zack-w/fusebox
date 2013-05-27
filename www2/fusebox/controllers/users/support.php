<?php 

if (!defined('BASEPATH')) die();

class Support extends SF_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("support_model");
	}
	
	public function index( $HasNoActive = null ){
		$ViewAll = ( !empty( $HasNoActive ) ) ? ( $HasNoActive ) : ( $this->input->get("viewall") );
		
		$Page = $this->input->get("page");
		$Page = ( empty( $Page ) ) ? ( 1 ) : ( intval( $Page ) );
		
		$ResultsPerPage = 25;
		
		$Start = (empty($Page) ? (0) : (intval($Page) * $ResultsPerPage - $ResultsPerPage));
		$StatusFilter = ($ViewAll)?(0):(14);
		
		$Results = $this->support_model->GetRecentTickets( $this->user->id, $Start, $ResultsPerPage, $StatusFilter );
		
		$Tickets = $Results[ 0 ];
		$NumResults = $Results[ 1 ];
		
		if( $NumResults == 0 )
			$NumPages = 0;
		else
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
			$this->navbar();
			
			$this->data[ "Tickets" ] = $Tickets;
			$this->data[ "ViewingAllTickets" ] = $ViewAll;
			$this->data[ "CurPage" ] = $Page;
			$this->data[ "NumPages" ] = $NumPages;
			$this->data[ "NumTickets" ] = $NumResults;
			
			if( !empty( $HasNoActive ) )
				$this->data[ "HasNoActive" ] = true;
			
			$this->view( "user/support" );
			$this->footer();
		}
	}
	
	public function ticket( $ID = null ) {
		$this->header("FuseBox - View Ticket");
		$this->navbar();
		
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
		
		$this->data[ "CanClose" ] = $this->settings_model->Get("support_users_canclose")->Value;
		$this->data[ "CanOpen" ] = $this->settings_model->Get("support_users_canopen")->Value;
		$this->data[ "Ticket" ] = $Ticket;
		$this->data[ "Replies" ] = $Replies;
		
		$this->view("user/support_ticket");
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
	
	public function toggletickets() {
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
		
		$Ticket = $this->support_model->GetTicketByID( $this->input->post( "ticket" ) );
		
		if (
			( $this->form_validation->run() == false || $this->support_model->UserCanAccessTicket( $this->input->post( "ticket" ) ) == false ) || // Is the form valid, and can user access ticket
			( $this->support_model->TicketExists( $this->input->post( "ticket" ) ) == false ) || // Does the ticket exist
			( $Ticket[ "Status" ] == 4 && $this->settings_model->Get("support_users_canopen")->Value == false ) // Can the user open the ticket if its closed?
		) {
			$this->ticket( $this->input->post( "ticket" ) ); // There were errors, so load the ticket again
			return;
		}
		
		$this->support_model->PostTicketReply( $this->input->post( "ticket" ), $this->user->id, $this->input->post( "message" ) );
		
		if( $this->settings_model->Get("support_users_canclose")->Value && $this->input->post( "close" ) == "closed" )
		{
			$this->support_model->UpdateTicketStatus( $this->input->post( "ticket" ), 4 );
		}else{
			$this->support_model->UpdateTicketStatus( $this->input->post( "ticket" ), 2 );
		}
		
		$this->ticket( $this->input->post( "ticket" ) );
	}
	
	public function ticket_open( $ID , $redirect = "support") {
		$CanOpen = $this->settings_model->Get("support_users_canopen")->Value;
		
		if( $CanOpen ) {
			$this->support_model->UpdateTicketStatus( $ID, 1 ); // TODO :: Calculate the correct ticket status
		}
		
		redirect( $redirect );
	}
	
	public function ticket_close( $ID , $redirect = "support" ) {
		$CanClose = $this->settings_model->Get("support_users_canclose")->Value;
		
		if( $CanClose ) {
			$this->support_model->UpdateTicketStatus( $ID, 4 ); // TODO :: Calculate the correct ticket status
		}
		
		redirect( $redirect );
	}
	
}

?>