<div class="main">
	<div class="main-inner">
		<div class="container">
		
				<div class="span12">
					<div class="widget widget-table">
						<div class="widget-header">
							<table style='width: 100%;'>
								<tr>
									<td style='width: 90%;'><i class="icon-list"></i> <h3>Manage Usergroups</h3></td>
									<td><a href='#'><button class="btn btn-mini">Add New</button></a></td>
								</tr>
							</table>
						</div>
						
						<div class="widget-content">
							<table class="table table-bordered" style='font-size: 12px;'>
								<tr style='background-color: #FAFAFA;'>
									<th style='background-color: #EEE;width: 100px;'></th>
									<th>Name</th>
									<th>Description</th>
									<th>Active Users</th>
								</tr>
								
								<?php
									foreach( $Usergroups as $Usergroup ) {
										$Desc = empty( $Usergroup->Description )?( "<i>No description entered..</i>" ):( $Usergroup->Description );
										$EditButton = "<a><button class='btn btn-mini'>Edit</button></a>";
										$DelButton = ($Usergroup->Deleteable)?( "<a><button class='btn btn-mini btn-danger'>Delete</button></a>" ):("");
										
										echo "
											<tr>
												<td style='text-align: center;'>{$EditButton} {$DelButton}</td>
												<td>{$Usergroup->Name}</td>
												<td>{$Desc}</td>
												<td>{$Usergroup->NumUsers}</td>
											</tr>
										";
									}
								?>
							</table>
						</div>
					</div>
				</div>
				
		</div>
	</div>
</div>