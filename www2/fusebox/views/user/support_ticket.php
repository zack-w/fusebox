<div class="main">
	<div class="main-inner">
		<div class="container">
			<style type="text/css">
				.bigInput {
					width: 75%;
				}
			</style>
			
			<div class="row" style="margin-bottom: 10px;">
				<div class="span12">
					<div class="widget" style="margin-bottom: 0px;">
						<div class="widget-header widget-table">
							<i class="icon-user"></i>
							<h3><? echo $Ticket[ "Subject" ]; ?></h3>
							<!--<h3><? echo $Reply[ "Username" ]; ?> - <u><? echo date( "m/d/y g:i A", $Reply[ "Date" ] ); ?></u></h3>-->
						</div>
						<div class="widget-content">
						
						<table class="table table-bordered table-striped">
							<tr>
								<td style='padding: 8px;'>
									<div style='margin-bottom: 11px;'><b style="margin-right: 5px;">Status:</b> <? echo ($this->support_status->GetButton($Ticket[ "Status" ])); ?></div>
									<div><b style="margin-right: 5px;">Department:</b> <span class='label'><? echo ($this->support_categories->GetCategory($Ticket[ "Category" ])); ?></span></div>
								</td>
								
								<td style='padding: 8px;'>
									<div style='margin-bottom: 11px;'><b>Opened:</b> <? echo date( "m/d/y g:i A", $Ticket[ "Date" ] ); ?></div>
									<div><b>Updated:</b> <? $LastReply = end( $Replies ); echo timespan( $LastReply['Date'] ); ?> ago</div>
								</td>
								
								<td style='padding: 8px;'>
									<?
									if($this->support_status->IsClosed($Ticket[ "Status" ]))
									{
										echo "<a href='support/ticket_open/".$Ticket[ 'ID' ]."' class='btn btn-success'>Open</a>";
									}
									else
									{
										echo "<a href='support/ticket_close/".$Ticket[ 'ID' ]."' class='btn btn-danger'>Close</a>";
									}
									?>
									
									<!--<a href="#" onclick="document.getElementById('message').focus();" class="btn btn-large" style="margin-left: 10px;">Reply</a>-->
								</td>
							</tr>
						</table>
						
						</div>
					</div>
				</div>
			</div>
			
			<? foreach ( $Replies as $ID => $Reply ) { ?>
				<div class="widget">
					<div class="widget-content" style="padding: 12px 25px 7px 25px;">
						<table style='width: 100%;'>
							<tr>
								<td style="width: 100%;">
									<h5>Posted by <? echo $Reply[ "Username" ]; ?> - <? echo timespan( $Reply[ "Date" ] ); ?> ago</h5>
								</td>
								
								<td>
									<table><tr>
										<td><a href="" class="btn btn-mini">Quote</a></td>
									</tr></table>
								</td>
							</tr>
						</table>
						
						<table class="table table-bordered" style="margin-top: 10px; margin-bottom: 10px;height: 70px;">
							<tr>
								<td valign="top"><? echo $Reply[ "Content" ]; ?></td>
							</tr>
						</table>
					</div>
				</div>

			<? } ?>
			
			<div class="widget">
				<div class="widget-content" style="padding: 12px 25px 7px 25px;">
					<table style='width: 100%;'>
						<tr>
							<td style="width: 100%;">
								<h5>Posted by Admin Lastname - 1 year ago</h5>
							</td>
							
							<td>
								<table><tr>
									<td><a href="" class="btn btn-mini">Quote</a></td>
								</tr></table>
							</td>
						</tr>
					</table>
					
					<table class="table table-bordered" style="margin-top: 10px; margin-bottom: 10px;height: 70px;">
						<tr>
							<td valign="top">
								This is a sample reply with a quote.
								
								<br /><br />
								
								<div style="width: 92%;margin: 0 4% 0 4%;font-weight: bold;font-size: 11px;">
									<span style="">Posted by Admin Lastname - 1 year ago</span>
									
									<div class="widget" style='font-weight: normal;font-size: 13px;'>
										<div class="widget-content" style="padding: 12px 25px 7px 25px;background-color: #F5F5F5;">
											This is a sample quoteed post
										</div>
									</div>
								</div>
								
								<div style="width: 92%;margin: 0 4% 0 4%;font-weight: bold;font-size: 11px;">
									<span style="">Posted by Admin Lastname - 1 year ago</span>
									
									<div class="widget" style='font-weight: normal;font-size: 13px;'>
										<div class="widget-content" style="padding: 12px 25px 7px 25px;background-color: #F5F5F5;">
											This is a second quote
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<a name="reply"></a>
			<div class="row">
				<div class="span12">
					<div class="widget" style="margin-top: 2em;">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3>Post Reply</h3>
						</div>
						<div class="widget-content">
							<form  class="form-horizontal" action="<? echo base_url( "support/ticket_respond" ); ?>" method="post">
								<input type="hidden" name="ticket" value="<? echo $Ticket[ "ID" ]; ?>" />
								
								<div class="control-group">
									<label class="control-label">Message</label>
									
									<div class="controls">
										<textarea name="message" id="message" rows="5" class="bigInput" style="resize: vertical;width: 97%;" ></textarea>
									</div>
								</div>
								
								<?php
									if( $Ticket[ "Status" ] != 4 ) {
								?>
								
								<div class="control-group">
									<label class="control-label">Close Ticket</label>
									
									<div class="controls">
										<input type="checkbox" name="close" value="closed" />
									</div>
								</div>
								
								<?php
									}
								?>
								
								<div class="control-group">
									<div class="controls">
										<input class="btn" type="submit" value="Submit Response"  />
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>