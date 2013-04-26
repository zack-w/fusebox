$(function () {
	$('.subnavbar').find ('li').each (function (i) {
		var mod = i % 3;
		
		if (mod === 2) {
			$(this).addClass ('subnavbar-open-right');
		}
	});
});

var SupportNumTicketsSelected = 0;
var SupportTicketsSelected = new Array();

function SelectSupportTicket( TicketID )
{
	if( SupportTicketsSelected[ TicketID ] == true )
	{
		SupportNumTicketsSelected--;
		SupportTicketsSelected[ TicketID ] = false;
	}else{
		SupportNumTicketsSelected++;
		SupportTicketsSelected[ TicketID ] = true;
	}
	
	if( SupportNumTicketsSelected > 0 )
	{
		$("#mange-tickets-widget").css( "display", "block" );
	}else{
		$("#mange-tickets-widget").css( "display", "none" );
	}
}

function EditSupportTickets()
{
	var Items = "";
	
	for( var Ticket in SupportTicketsSelected )
	{
		Items = Items + "," + Ticket;
	}
	
	window.location.replace( window.location + "/toggletickets?tickets=" + Items );
}
