<div class="main">
	<div class="main-inner">
		<div class="container">
		
			<div class="row">
				<div class="span2">
					<div class="widget">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3>Categories</h3>
						</div>
						
						<div class="widget-content">
							<?php
								foreach( Permissions::GetCategories() as $Cat )
								{
									$CatName = lang( "permissioncategory_{$Cat->Key}_title" );
									echo "<a href='?id={$CurUsergroup}&cat={$Cat->ID}'><strong>{$CatName}</strong></a><br />";
								}
							?>
						</div>
					</div>
				</div>
				
				<div class="span10">
					<div class="widget widget-table">
						<div class="widget-header">
							<i class="icon-list"></i> <h3>Edit Usergroup</h3>
						</div>
						
						<div class="widget-content">
							<table class="table table-bordered" style='font-size: 12px;'>
								<tr style='background-color: #FAFAFA;'>
									<th>Permission</th>
									<th>Description</th>
									<th>Value</th>
								</tr>
								
								<?php
									echo "
										<tr>
											<td>Usergroup Name</td>
											<td>This is the name of the usergroup</td>
											<td><input type='text' value='' /></td>
										</tr>
									";
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>