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
								<? foreach ($tickets as $i => $ticket) { ?>
								<tr>
									<td><a href="<? echo base_url("support/ticket/".$ticket["id"]); ?>"><? echo $ticket["title"]; ?></a></td>
									<td><? echo $ticket["replies"]; ?></td>
									<td><? echo ago($ticket["timestamp"]); ?></td>
									<td><? echo ($ticket["lastupdated"] == 0) ? 'Never' : ago($ticket["lastupdated"]); ?></td>
									<td><? echo $ticket["lastuser"]; ?></td>
									<td><? echo $ticket["status"]; ?></td>
									<td>
										<? if ($ticket["status"] == "Closed") { ?>
											<a href="<? echo base_url("support/ticket_open/".$ticket["id"]); ?>" class="btn btn-success">Open</a>
										<? } else { ?>
											<a href="<? echo base_url("support/ticket_close/".$ticket["id"]); ?>" class="btn btn-danger">Close</a>
										<? } ?>
									</td>
								</tr>
								<? } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>