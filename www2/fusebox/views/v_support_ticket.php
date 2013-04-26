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
					<div class="widget" style="margin-bottom: 0px;">
						<div class="widget-header widget-table">
							<i class="icon-user"></i>
							<h3><? echo ($this->support_status->IsClosed($Ticket[ "Status" ])) ? "<font color='red'>Closed</font>" : "<font color='green'>Open</font>"; ?> | <? echo $Ticket[ "Subject" ]; ?></h3>
							<!--<h3><? echo $Reply[ "Username" ]; ?> - <u><? echo date( "m/d/y g:i A", $Reply[ "Date" ] ); ?></u></h3>-->
						</div>
						<div class="widget-content">

						<table class="table table-bordered table-striped">
							<tr>
								<td>
									<h3>Status: <? echo ($this->support_status->IsClosed($Ticket[ "Status" ])) ? "<font color='red'>Closed</font>" : "<font color='green'>Open</font>"; ?></h3>
									<h3>Department: <? echo ($this->support_categories->GetCategory($Ticket[ "Category" ])); ?></h3>
								</td>
								<td>
									<h3>Opened: <? echo date( "m/d/y g:i A", $Ticket[ "Date" ] ); ?></h3>
									<h3>Updated: <? echo timespan( end($Replies)['Date'] ); ?></h3>
								</td>
								<td>
									
									<?
									if($this->support_status->IsClosed($Ticket[ "Status" ]))
									{
										echo "<a href='support/ticket_open/".$Ticket[ 'ID' ]."' class='btn btn-large btn-success'>Open</a>";
									}
									else
									{
										echo "<a href='support/ticket_close/".$Ticket[ 'ID' ]."' class='btn btn-large btn-danger'>Close</a>";
									}
									?>

									<a href="#" onclick="document.getElementById('message').focus();" class="btn btn-large" style="margin-left: 10px;">Reply</a>
									
								</td>
							</tr>
						</table>

						<? foreach ( $Replies as $ID => $Reply ) { ?>
			
							<h5><? echo $Reply[ "Username" ]; ?> - <u><? echo date( "m/d/y g:i A", $Reply[ "Date" ] ); ?></u></h5>
							<table class="table table-bordered" style="margin-top: 10px; margin-bottom: 10px;">
								<tr>
									<td><? echo $Reply[ "Content" ]; ?></td>
								</tr>
							</table>
			
						<? } ?>
			

						</div>
					</div>
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
										<textarea name="message" id="message" rows="5" class="bigInput"></textarea>
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