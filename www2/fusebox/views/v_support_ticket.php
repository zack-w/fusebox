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
					<h1><? echo $original["title"]; ?></h1>
					<h3>Status: <? echo ($original["closed"]) ? "Closed" : "Open"; ?></h3>
					<hr>
				</div>
			</div>
			
			<div class="row">
				<div class="span12">
					<div class="widget widget-table">
						<div class="widget-header">
							<i class="icon-user"></i>
							<h3><? echo $original["username"]; ?> - <u><? echo ago($original["timestamp"]); ?></u></h3>
						</div>
						<div class="widget-content">
							<table class="table table-bordered">
								<tr>
									<td><? echo $original["message"]; ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			
			<? foreach ($replies as $k => $reply) { ?>
	
			<div class="row">
				<div class="span12">
					<div class="widget">
						<div class="widget-header widget-table">
							<i class="icon-user"></i>
							<h3><? echo $reply["username"]; ?> - <u><? echo ago($reply["timestamp"]); ?></u></h3>
						</div>
						<div class="widget-content">
							<table class="table table-bordered">
								<tr>
									<td><? echo $reply["message"]; ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<? } ?>
			
			<div class="row">
				<div class="span12">
					<div class="widget">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3>Post Reply</h3>
						</div>
						<div class="widget-content">
							<form  class="form-horizontal" action="<? echo base_url("support/ticket_respond"); ?>" method="post">
								<input type="hidden" name="ticket" value="<? echo $original["id"]; ?>" />
								<div class="control-group">
									<label class="control-label">Message</label>
									<div class="controls">
										<textarea name="message" rows="5" class="bigInput"></textarea>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<input type="submit" value="Submit Response"  />
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