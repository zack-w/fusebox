<?php
	$page_title = "Support";
	include($BASEPATH."includes/support/ticket.class.php");
?>
<div class="container">
	
	      <div class="row">
	      	
	      	<div class="span8">
	      		
	      		<div class="widget">
						
					<div class="widget-header">
						<i class="icon-comment"></i>
						<h3><?php echo $LANGUAGE['support_tickets']; ?></h3>
					</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<h3><?php echo $LANGUAGE['support_ticketStatus_open']; ?> <a href="#"><?php echo $LANGUAGE['support_ticketStatus_closed']; ?></a> <a href="#"><?php echo $LANGUAGE['support_ticketStatus_onHold']; ?></a></h3>
						<br />
						<table class="table table-striped">
							<thead>
				                <tr>
				                  	<th></th>
				                 	<th><?php echo $LANGUAGE['support_ticketNumber']; ?></th>
				                 	<th><?php echo $LANGUAGE['support_ticketSubject']; ?></th>
				                  	<th><?php echo $LANGUAGE['support_ticketLastResponse']; ?></th>
				                  	<th><?php echo $LANGUAGE['support_ticketOpened']; ?></th>
				                  	<th><?php echo $LANGUAGE['support_ticketUpdated']; ?></th>
				                  	<th><?php echo $LANGUAGE['support_ticketPriority']; ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php
									$tickets = $DB->queryArray("SELECT * FROM support_tickets WHERE uid = '".$USER->getUid()."'");
									foreach ($tickets as $i => $ticket) {
										$ticket = new Ticket($ticket['id']);
				            	?>

				                <tr>
				                  	<td><input type="checkbox" name="selected" value="<?php echo $ticket->id; ?>" /></td>
				                  	<a href="#">
				                  		<td><?php echo $ticket->id; ?></td>
					                  	<td><?php echo $ticket->subject; ?></td>
					                  	<td>(Staff) Patrick Hampson</td>
					                  	<td>2 days ago</td>
					                  	<td>1 day ago</td>
					                  	<td><?php echo $ticket->priority; ?></td>
				                 	</a>
				                </tr>

				                <?php
				                	} // ./foreach
				                ?>
				            </tbody>
						</table>
					</div> <!-- /widget-content -->	
				</div> <!-- /widget -->	
		    </div> <!-- /span8 -->
		    <div class="span4">			
				<div class="widget widget-plain">
					<div class="widget-content">
						<a href="javascript:;" class="btn btn-large btn-warning btn-support-ask">New Ticket</a>	
						<a href="javascript:;" class="btn btn-large btn-support-contact">Contact Support</a>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
				<div class="widget widget-box">
					<div class="widget-header">	
						<h3>Most Popular Questions</h3>			
					</div> <!-- /widget-header -->
					<div class="widget-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->
			</div> <!-- /span4 -->
	      </div> <!-- /row -->
	    </div> <!-- /container -->