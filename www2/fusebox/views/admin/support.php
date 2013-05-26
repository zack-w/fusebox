<div class="main">
	<div class="main-inner">
		<div class="container">
			<style type="text/css">
				.bigInput {
					width: 75%;
				}
			</style>
			
			<div>
				<div class="widget widget-table">
					<div class="widget-header">
						<i class="icon-list"></i> <h3>Active Tickets - <?php echo $NumTickets; ?> Total</h3>
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
												<b>You don't have any tickets.</b>
											</td>
										</tr>
									";
								} else {
									foreach ( $Tickets as $Ticket )
									{
										$TicketID = $Ticket[ "ID" ];
										$URL = base_url( "admin/support/ticket/" . $Ticket[ "ID" ] );
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
					
					<table style='width: 100%;'>
						<tr>
							<td style='width: auto;'>
								<? if( !empty( $Tickets ) && count( $Tickets ) != 0 ) { ?>
								
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
							</td>
							
							<td style='text-align: right;'>
								<div class="pagination pagination-large">
									<ul class="pagination">
										<?php
											if( $NumPages > 1 )
											{
												$PrevClass = ( $CurPage > 1 )?( "" ):( "disabled" );
												$NextClass = ( $NumPages > $CurPage )?( "" ):( "disabled" );
												
												echo "<ul>
													<li class='{$PrevClass}'><a href='?page=" . ($CurPage - 1) . "'>Prev</a></li>
													<li class='{$NextClass}'><a href='?page=" . ($CurPage + 1) . "'>Next</a></li>
												</ul>";
											}
										?>
									</ul>
								</div>
							</td>
						</tr>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>