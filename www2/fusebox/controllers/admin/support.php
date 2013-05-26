<?php 

if (!defined('BASEPATH')) die();

class Support extends SF_Controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model("support_model");
	}
	
	public function index() {
		$StatusFilter = $this->input->get("status");
		$StatusFilter = ( empty( $StatusFilter ) ) ? ( 6 ) : ( intval( $StatusFilter ) );
		
		$CatFilter = $this->input->get("cat");
		$CatFilter = ( empty( $CatFilter ) ) ? ( 0 ) : ( intval( $CatFilter ) );
		
		$Page = $this->input->get("page");
		$Page = ( empty( $Page ) ) ? ( 1 ) : ( intval( $Page ) );
		
		$ResultsPerPage = 25;
		
		$Start = (empty($Page) ? (0) : (intval($Page) * $ResultsPerPage - $ResultsPerPage));
		$Results = $this->support_model->GetRecentTickets( $Start, $ResultsPerPage, $StatusFilter, $CatFilter );
		
		$Tickets = $Results[ 0 ];
		$NumResults = $Results[ 1 ];
		
		if( $NumResults == 0 )
			$NumPages = 0;
		else
			$NumPages = ceil( $NumResults / $ResultsPerPage );
		
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
		
		if( $StatusFilter == 0 ) {
			foreach( $this->support_status->Items as $ItemID => $Item ) {
				$StatusFilter = $StatusFilter | pow( 2, $ItemID );
			}
		}
		
		if( $CatFilter == 0 ) {
			foreach( $this->support_categories->Items as $ItemID => $Item ) {
				$CatFilter = $CatFilter | pow( 2, $ItemID );
			}
		}
		
		$this->data[ "StatusMesh" ] = $StatusFilter;
		$this->data[ "CatMesh" ] = $CatFilter;
		$this->data[ "Tickets" ] = $Tickets;
		$this->data[ "CurPage" ] = $Page;
		$this->data[ "NumPages" ] = $NumPages;
		$this->data[ "NumTickets" ] = $NumResults;
		
		$this->view( "admin/support" );
		$this->footer();
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

		$this->data[ "Ticket" ] = $Ticket;
		$this->data[ "Replies" ] = $Replies;
		
		$this->view("admin/support_ticket");
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
		redirect( $redirect );
	}
	
	public function ticket_open( $ID , $redirect = "support") {
		$this->support_model->UpdateTicketStatus( $ID, 1 ); // TODO :: Calculate the correct ticket status
		redirect( $redirect );
	}
	
}

?>