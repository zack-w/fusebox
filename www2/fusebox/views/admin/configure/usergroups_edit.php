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
									echo "<a href='?id={$CurUsergroup}&cat={$Cat->ID}'><strong>{$Cat->GetName()}</strong></a><br />";
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
									if( $CurCat == 1 ) {
										echo "
											<tr>
												<td>Usergroup Name</td>
												<td>This is the name of the usergroup</td>
												<td><input type='text' value='' /></td>
											</tr>
										";
									}elseif( $CurCat == 2 ) {
										echo "
											<tr>
												<td>Support Departments</td>
												<td>What support departments is this user apart of?</td><td>
										";
										
										foreach( $this->support_categories->Items as $CatID => $CatName ) {
											echo "<input type='checkbox' name='department_{$CatID}' style='margin: 0 5px 3px 0;' /> {$CatName}<br />";
										}
										
										echo "</td></tr>";
									}
									
									foreach( Permissions::GetAll() as $Permission ) {
										if( $Permission->Category == $CurCat ) {
											echo "
												<tr>
													<td>{$Permission->GetName()}</td>
													<td>{$Permission->GetDesc()}</td>
													
													<td>
														<select>
															<option>Allow</option>
															<option>Disallow</option>
														</select>
													</td>
												</tr>
											";
										}
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