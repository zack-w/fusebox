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
								foreach( $SettingCats as $SettingCatID => $SettingCat )
								{
									echo "<a href='?cat={$SettingCatID}'><strong>" . $SettingCat . "</strong></a><br />";
								}
							?>
						</div>
					</div>
				</div>
				
				<div class="span10">
					<div class="widget widget-table">
						<div class="widget-header">
							<i class="icon-comment"></i>
							<h3><?php echo $CurSettingCat; ?></h3>
						</div>
						
						<div class="widget-content">
							<table class="table table-bordered" style="font-size: 12px;">
								<tr style='background-color: #FAFAFA;'>
									<th>Setting</th>
									<th>Description</th>
									<th>Value</th>
								</tr>
								
								<?php
									foreach( $Settings as $Setting )
									{
										$SettingName = $Setting->GetText( "title" );
										$SettingDesc = $Setting->GetText( "desc" );
										$HTML = $Setting->HTML_Form( $Setting->Key, $Setting->Type, $Setting->Value, $SettingName, $Setting->Options );
										
										echo "
											<tr>
												<td>{$SettingName}</td>
												<td>{$SettingDesc}</td>
												<td>{$HTML}</td>
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
</div>

<script>
	var Loc = location.protocol + '//' + location.host + location.pathname + "/ajax_updatesetting";
	
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
						text: 'Unable to save setting ' + RealName,
					});
				}else if( Resp == "success" ) {
					$.msgGrowl ({
						type: "success",
						title: 'Save Success',
						lifetime: 12000,
						text: 'Successfully saved setting ' + RealName,
					});
				}else{
					alert( Resp );
				}
			}
		};
		
		HTTP.open( "GET", Loc + "?key=" + Key + "&value=" + Ele.value, true );
		HTTP.send();
	}
</script>