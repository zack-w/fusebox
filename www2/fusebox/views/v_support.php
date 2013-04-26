<div class="main">
	<div class="main-inner">
		<div class="container">
			<style type="text/css">
				.bigInput {
					width: 75%;
				}
			</style>
			
			<div class="row">
				<div class="span4">
					<div class="widget">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3>Post Ticket</h3>
						</div>
						<div class="widget-content">
							<form action="<? echo base_url("support/ticket_create"); ?>" method="post">
							
								<div class="control-group">
									<label class="control-label">Title</label>
									<div class="controls">
										<input type="text" name="title" placeholder="No Title Entered" class="bigInput" maxlength=30 />
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label">Message</label>
									
									<div class="controls">
										<textarea name="message" rows="5" class="bigInput" style="resize: vertical;width: 97%;"></textarea>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label">Category</label>
									<div class="controls">
										<select name='category'>
											<?php
												foreach( $this->support_categories->Items as $ID => $Text )
												{
													echo "<option value='{$ID}'>{$Text}</option>";
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label">Priority</label>
									<div class="controls">
										<select name='priority'>
											<?php
												foreach( $this->support_priorities->Items as $ID=>$Text )
												{
													echo "<option value='{$ID}'>{$Text}</option>";
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls">
										<input class="btn" type="submit" value="Submit Ticket"  />
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				<div class="span8">
					<div class="widget widget-table">
						<div class="widget-header">
							<i class="icon-list"></i>
							<h3>Your Tickets</h3>
						</div>
						
						<div class="widget-content">
							<table class="table table-bordered" style='font-size: 12px;'>
								<tr style='background-color: #FAFAFA;'>
									<th style='background-color: #EEE;'></th>
									<th>Title</th>
									<!--<th>Created</th>-->
									<th>Last Updated</th>
									<!--<th>Last User</th>-->
									<th>Status</th>
									<th>Category</th>
								</tr>
								
								<?php
									if( empty( $Tickets ) || count( $Tickets ) == 0 )
									{
										echo "
											<tr>
												<td colspan=5 style='text-align: center;padding: 15px;'>
													<b>You don't have any tickets!</b>
												</td>
											</tr>
										";
									} else {
										foreach ( $Tickets as $Ticket )
										{
											$TicketID = $Ticket[ "ID" ];
											$URL = base_url( "support/ticket/" . $Ticket[ "ID" ] );
											$Title = $Ticket[ "Subject" ];
											//$Date = timespan( $Ticket[ "Date" ] );
											$LastReply = timespan( $Ticket[ "LastReply" ]  );
											//$LastReplyUser = $Ticket[ "LastReplyUser" ]->username;
											$Status = $this->support_status->GetButton( $Ticket[ "Status" ] );
											$Category = $this->support_categories->GetCategory( $Ticket[ "Category" ] );
											$IsClosed = $this->support_status->IsClosed( $Ticket[ "Status" ] );
											
											echo "
												<tr id='ticket_{$TicketID}'>
													<td style='text-align: center;'><input onclick=\"SelectSupportTicket({$TicketID});\" type='checkbox' /></td>
													<td><a href='{$URL}'>{$Title}</a></td>
													<td>{$LastReply} ago</td>
													<td>{$Status}</td>
													<td><span class='label'>{$Category}</span></td>
												</tr>
											";
										}
									}
								?>
							</table>
						</div>
						
						<? if( !empty( $Tickets ) && count( $Tickets ) != 0 ) { ?>
						<br />
						
						<div class="widget-content" style='width: 290px;display: none;' id="mange-tickets-widget">
							<table style='margin: 10px;' cellspacing=20>
								<tr>
									<td style="padding-right: 10px;">
										<select style="margin: 0px;">
											<option>Open/Close Ticket(s)</option>
										</select>
									</td>
									
									<td style='text-align: center;'>
										<a href="#" class="btn" onclick="EditSupportTickets();">Go</a>
									</td>
								</tr>
							</table>
						</div>
						
						<? } ?>
					</div>
				</div>
			</div>
			
			<b>TODO :: Add paging here</b>
			
		</div>
	</div>
</div>