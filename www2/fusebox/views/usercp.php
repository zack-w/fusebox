<div class="container">
  <div class="row">
	<div class="span8">   
		<div class="widget ">
			
			<div class="widget-header">
				<i class="icon-user"></i>
				<h3>Your Account</h3>
			</div>
			
			<div class="widget-content">
			
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#profile" data-toggle="tab"><? echo lang("base_usercp_profile"); ?></a>
						</li>
						<li>
							<a href="#contact" data-toggle="tab"><? echo lang("base_usercp_contactInfo"); ?></a>
						</li>
					</ul>
					
					<br />
					
					<form class="form-horizontal" method="post" action="<?php echo site_url( "user/update" ); ?>">
						<div class="tab-content">
							<div class="tab-pane active" id="profile">
								<fieldset>
									<div class="control-group">											
										<label class="control-label" for="firstname"><? echo lang("base_usercp_firstName"); ?></label>

										<div class="controls">
											<input type="text" class="input-medium" name="firstname" value="<?php echo $user->first_name; ?>" <?php if(!$CanChangeFirstname) echo "disabled"; ?>>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="lastname"><? echo lang("base_usercp_lastName"); ?></label>
										<div class="controls">
											<input type="text" class="input-medium" name="lastname" value="<?php echo $user->last_name; ?>" <?php if(!$CanChangeLastname) echo "disabled"; ?>>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="email"><? echo lang("base_usercp_emailAddress"); ?></label>
										<div class="controls">
											<input type="text" class="input-large" id="email" value="<?php echo $user->email; ?>" <?php if(!$CanChangeEmail) echo "disabled"; ?>>
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<br /><br />
									
									<div class="control-group">											
										<label class="control-label" for="password1"><? echo lang("base_usercp_password"); ?></label>
										<div class="controls">
											<input type="password" class="input-medium" id="password1" value="password">
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
									
									<div class="control-group">											
										<label class="control-label" for="password2"><? echo lang("base_usercp_confirm"); ?></label>
										<div class="controls">
											<input type="password" class="input-medium" id="password2" value="password">
										</div> <!-- /controls -->				
									</div> <!-- /control-group -->
								</fieldset>
							</div><!-- /tab-pane active -->

								<div class="tab-pane" id="contact">
									<fieldset>
										<div class="control-group">
											<label class="control-label" for="company"><? echo lang("base_usercp_companyName"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="company" value="<?php echo $user->company; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	

										<div class="control-group">
											<label class="control-label" for="address1"><? echo lang("base_usercp_address1"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="address1" value="<?php echo $user->address1; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	
										<div class="control-group">
											<label class="control-label" for="address2"><? echo lang("base_usercp_address2"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="address2" value="<?php echo $user->address2; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->

										<div class="control-group">
											<label class="control-label" for="city"><? echo lang("base_usercp_city"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="city" value="<?php echo $user->city; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	

										<div class="control-group">											
											<label class="control-label" for="state"><? echo lang("base_usercp_state"); ?></label>
											<div class="controls">
												<select name="state"> 
													<?php
														$states = array('AL'=>"Alabama",  
																	'AK'=>"Alaska",  
																	'AZ'=>"Arizona",  
																	'AR'=>"Arkansas",  
																	'CA'=>"California",  
																	'CO'=>"Colorado",  
																	'CT'=>"Connecticut",  
																	'DE'=>"Delaware",  
																	'DC'=>"District Of Columbia",  
																	'FL'=>"Florida",  
																	'GA'=>"Georgia",  
																	'HI'=>"Hawaii",  
																	'ID'=>"Idaho",  
																	'IL'=>"Illinois",  
																	'IN'=>"Indiana",  
																	'IA'=>"Iowa",  
																	'KS'=>"Kansas",  
																	'KY'=>"Kentucky",  
																	'LA'=>"Louisiana",  
																	'ME'=>"Maine",  
																	'MD'=>"Maryland",  
																	'MA'=>"Massachusetts",  
																	'MI'=>"Michigan",  
																	'MN'=>"Minnesota",  
																	'MS'=>"Mississippi",  
																	'MO'=>"Missouri",  
																	'MT'=>"Montana",
																	'NE'=>"Nebraska",
																	'NV'=>"Nevada",
																	'NH'=>"New Hampshire",
																	'NJ'=>"New Jersey",
																	'NM'=>"New Mexico",
																	'NY'=>"New York",
																	'NC'=>"North Carolina",
																	'ND'=>"North Dakota",
																	'OH'=>"Ohio",  
																	'OK'=>"Oklahoma",  
																	'OR'=>"Oregon",  
																	'PA'=>"Pennsylvania",  
																	'RI'=>"Rhode Island",  
																	'SC'=>"South Carolina",  
																	'SD'=>"South Dakota",
																	'TN'=>"Tennessee",  
																	'TX'=>"Texas",  
																	'UT'=>"Utah",  
																	'VT'=>"Vermont",  
																	'VA'=>"Virginia",  
																	'WA'=>"Washington",  
																	'WV'=>"West Virginia",  
																	'WI'=>"Wisconsin",  
																	'WY'=>"Wyoming");
														if(!isset($user->state))
															echo '<option value="" selected="selected">'.lang("base_usercp_selectAState").'</option>';
														else
															echo '<option value="">'.lang("base_usercp_selectAState").'</option>';

														foreach($states as $code => $state)
														{
															echo '<option value="'.$code.'"';
															if($code == $user->state)
																echo ' selected="selected">';
															else
																echo '>';
															echo $state.'</option>';
														}
													?>
												</select>
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->

										<div class="control-group">
											<label class="control-label" for="zip"><? echo lang("base_usercp_zip"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="zip" value="<?php echo $user->zip; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	

										<div class="control-group">
											<label class="control-label" for="country"><? echo lang("base_usercp_country"); ?></label>
											<div class="controls">
												<select name="country"> 
													<?php
														$countries = array(   
																	'United States'=>"United States",
																	'Other'=>"Other");
														if(!isset($user->country))
															echo '<option value="" selected="selected">'.lang("base_usercp_selectACountry").'</option>';
														else
															echo '<option value="">'.lang("base_usercp_selectACountry").'</option>';

														foreach($countries as $code => $country)
														{
															echo '<option value="'.$code.'"';
															if($country == $user->country)
																echo ' selected="selected">';
															else
																echo '>';
															echo $country.'</option>';
														}
													?>
												</select>
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	

										<div class="control-group">
											<label class="control-label" for="phone"><? echo lang("base_usercp_phoneNumber"); ?></label>
											<div class="controls">
												<input type="text" class="input-medium" name="phone" value="<?php echo $user->phone; ?>">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->	
									</fieldset>
								</div><!-- /tab-pane -->

						</div><!-- /tab-content -->
						
						<div class="form-actions">
							<button type="submit" class="btn btn-primary"><? echo lang("base_usercp_save"); ?></button> 
							<button class="btn"><? echo lang("base_usercp_cancel"); ?></button>
						</div> 											
					</form>		
				</div><!-- /tabbable -->
			</div><!-- /widget-content -->
		</div> <!-- /widget -->
	</div><!-- /span8 -->
  </div> <!-- /row -->
</div> <!-- /container --> 