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
												<td><input onblur='onSettingUpdated(this, \"name\", \"Usergroup Name\");' type='text' value='{$UsergroupObj->Name}' /></td>
											</tr>
										";
									}elseif( $CurCat == 2 ) {
										echo "
											<tr>
												<td>Support Departments</td>
												<td>What support departments is this user apart of?</td><td>
										";
										
										foreach( $this->support_categories->Items as $CatID => $CatName ) {
											$Checked = ( $UsergroupObj->HasTicketCat( $CatID ) )?( "checked" ):( "" );
											echo "<input {$Checked} onchange='onSettingUpdated(this, \"{$CatID}\", \"Support Departments\");' type='checkbox' name='department_{$CatID}' style='margin: 0 5px 3px 0;' /> {$CatName}<br />";
										}
										
										echo "</td></tr>";
									}
									
									foreach( Permissions::GetAll() as $Permission ) {
										if( $Permission->Category == $CurCat ) {
											$SelectDisallow = ( $UsergroupObj->HasPermission( $Permission->ID ) == false )?( "selected" ):( "" );
											
											echo "
												<tr>
													<td>{$Permission->GetName()}</td>
													<td>{$Permission->GetDesc()}</td>
													
													<td>
														<select onfocus='this.selectedInfex = -1;' onchange='onSettingUpdated(this, \"{$Permission->Key}\", \"{$Permission->GetName()}\");'>
															<option value='1'>Allow</option>
															<option value='0' {$SelectDisallow}>Disallow</option>
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

<script>
	var Loc = "<?php echo base_url( "/admin/conf_usergroups/ajax_updateperm" ); ?>";
	
	function onSettingUpdated( Ele, Key, RealName )
	{
		var HTTP = new XMLHttpRequest();
		
		HTTP.onreadystatechange = function() {
			if( HTTP.readyState == 4 && HTTP.status == 200 ) {
				var Resp = HTTP.responseText;
				
				if( Resp == "error" ) {
					$.msgGrowl ({
						type: "error",
						title: 'Save Failure',
						lifetime: 12000,
						text: 'Unable to save permission ' + RealName,
					});
				}else if( Resp == "success" ) {
					$.msgGrowl ({
						type: "success",
						title: 'Save Success',
						lifetime: 12000,
						text: 'Successfully saved permission ' + RealName,
					});
				}else{
					alert( Resp );
				}
			}
		};
		
		var Val = Ele.value;
		
		if( Ele.type == "checkbox" ) {
			Val = ( Ele.checked )?( "enable_cat" ):( "disable_cat" );
		}
		
		HTTP.open( "GET", Loc + "?key=" + Key + "&value=" + Val + "&usergroup=<?php echo $CurUsergroup; ?>", true );
		HTTP.send();
	}
</script>