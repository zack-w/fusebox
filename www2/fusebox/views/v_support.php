<div class="main">
	<div class="main-inner">
		<div class="container">
			<style type="text/css">
				.bigInput {
					width: 75%;
				}
			</style>
			
			<div class="row">
				<div class="span12">
					<div class="widget">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3>Post Ticket</h3>
						</div>
						<div class="widget-content">
							<form  class="form-horizontal" action="<? echo base_url("support/ticket_create"); ?>" method="post">
							
								<div class="control-group">
									<label class="control-label">Title</label>
									<div class="controls">
										<input type="text" name="title" placeholder="Title" class="bigInput" />
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label">Message</label>
									<div class="controls">
										<textarea name="message" rows="5" class="bigInput"></textarea>
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
										<input type="submit" value="Submit Ticket"  />
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
	
			<div class="row">
				<div class="span12">
					<div class="widget widget-table">
						<div class="widget-header">
							<i class="icon-list"></i>
							<h3>Your Tickets</h3>
						</div>
						<div class="widget-content">
							<table class="table table-bordered">
								<tr>
									<th>Title</th>
									<th>Replies</th>
									<th>Created</th>
									<th>Last Updated</th>
									<th>Last User</th>
									<th>Status</th>
									<th>Control</th>
								</tr>
								
								<?php
									foreach ( $Tickets as $Ticket )
									{
										$URL = base_url( "support/ticket/" . $Ticket[ "ID" ] );
										$Title = $Ticket[ "Subject" ];
										$NumReplies = $Ticket[ "NumReplies" ];
										$Date = date( "m/d/y g:i A", $Ticket[ "Date" ] );
										$LastReply = ( $Ticket[ "LastReply" ] == 0 )? ( "Never" ) : ( date( "m/d/y g:i A", $Ticket[ "LastReply" ]  ) );
										$LastReplyUser = $Ticket[ "LastReplyUser" ]->username;
										$Status = $this->support_status->GetStatus( $Ticket[ "Status" ] );
										$IsClosed = $this->support_status->IsClosed( $Ticket[ "Status" ] );
										
										echo "
										<tr>
											<td><a href='{$URL}'>{$Title}</a></td>
											<td>{$NumReplies}</td>
											<td>{$Date}</td>
											<td>{$LastReply}</td>
											<td>{$LastReplyUser}</td>
											<td>" . $Status[ "Text" ] . "</td>
											<td>
										";
										
										if( $IsClosed ) {
											$Goto = base_url( "support/ticket_open/" . $Ticket[ "ID" ] );
											echo "<a href='{$Goto}' class='btn btn-success'>Open</a>";
										} else {
											$Goto = base_url( "support/ticket_close/" . $Ticket[ "ID" ] );
											echo "<a href='{$Goto}' class='btn btn-danger'>Close</a>";
										}
										
										echo "</td></tr>";
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>