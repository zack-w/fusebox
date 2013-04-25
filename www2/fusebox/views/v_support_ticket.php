<div class="main">
	<div class="main-inner">
		<div class="container">
			<style type="text/css">
				.bigInput {
					width: 75%;
				}
			</style>
			
			<div class="row">
				<div class="span8">
					<h1><? echo $Ticket[ "Subject" ]; ?></h1>
					<h3>Status: <? echo ($this->support_status->IsClosed($Ticket[ "Status" ])) ? "Closed" : "Open"; ?></h3>
					<h3><a href="#reply" onclick="document.getElementById('message').focus();">Reply</a></h3>
					<hr>
				</div>
			</div>
			
			<? foreach ( $Replies as $ID => $Reply ) { ?>
			
			<div class="row">
				<div class="span12">
					<div class="widget" style="margin-bottom: 0px;">
						<div class="widget-header widget-table">
							<i class="icon-user"></i>
							<h3><? echo $Reply[ "Username" ]; ?> - <u><? echo date( "m/d/y g:i A", $Reply[ "Date" ] ); ?></u></h3>
						</div>
						<div class="widget-content">
							<table class="table table-bordered">
								<tr>
									<td><? echo $Reply[ "Content" ]; ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<? } ?>
			
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