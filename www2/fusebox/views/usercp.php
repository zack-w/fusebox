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
							<a href="#profile" data-toggle="tab">Profile</a>
						</li>
					</ul>
					
					<br>
					
					<div class="tab-content">
						<div class="tab-pane active" id="profile">
						
						<form class="form-horizontal" method="post" action="<?php echo site_url( "user/update" ); ?>">
							<fieldset>
								<div class="control-group">											
									<label class="control-label" for="firstname">First Name</label>

									<div class="controls">
										<input type="text" class="input-medium" name="firstname" value="<?php echo $user->first_name; ?>" <?php if(!$CanChangeFirstname) echo "disabled"; ?>>
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<div class="control-group">											
									<label class="control-label" for="lastname">Last Name</label>
									<div class="controls">
										<input type="text" class="input-medium" name="lastname" value="<?php echo $user->last_name; ?>" <?php if(!$CanChangeLastname) echo "disabled"; ?>>
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<div class="control-group">											
									<label class="control-label" for="email">Email Address</label>
									<div class="controls">
										<input type="text" class="input-large" id="email" value="<?php echo $user->email; ?>" <?php if(!$CanChangeEmail) echo "disabled"; ?>>
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<br /><br />
								
								<div class="control-group">											
									<label class="control-label" for="password1">Password</label>
									<div class="controls">
										<input type="password" class="input-medium" id="password1" value="password">
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<div class="control-group">											
									<label class="control-label" for="password2">Confirm</label>
									<div class="controls">
										<input type="password" class="input-medium" id="password2" value="password">
									</div> <!-- /controls -->				
								</div> <!-- /control-group -->
								
								<br />
								
								<div class="form-actions">
									<button type="submit" class="btn btn-primary">Save</button> 
									<button class="btn">Cancel</button>
								</div> <!-- /form-actions -->
							</fieldset>
						</form>
						</div>								
					</div>
				</div>
				
				</div> <!-- /widget-content -->
		</div> <!-- /widget -->
		</div> <!-- /span8 -->
		</div> <!-- /row -->
	</div> <!-- /container -->