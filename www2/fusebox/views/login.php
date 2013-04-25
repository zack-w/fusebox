<link href="<? echo base_url("assets/css/pages/signin.css"); ?>" rel="stylesheet" type="text/css">

<div class="account-container">
	<div class="content clearfix">
		<form action="<? echo base_url("user/login"); ?>" method="post">
			<h1><?php echo lang("login_heading"); ?></h1>		
			
			<div class="login-fields">
				<div class="control-group">
					<p><? echo lang("login_subheading"); ?></p>
					<br />
					
					<div class="field">
						<label for="username"><? echo lang("index_email_th"); ?>:</label>
						<input type="text" id="identity" name="identity" value="<? echo $this->data[ "email_fill" ]; ?>" placeholder="<? echo lang("index_email_th"); ?>" class="login username-field" />
						
						<?php
							if( !empty( $AccountEmailError ) )
								echo "<span class='error' style='display: inline;'>That email isn't in our system.</span>";
						?>
					</div>
					
					<div class="field">
						<label for="password"><? echo lang("login_password_label"); ?>:</label>
						<input type="password" id="password" name="password" value="" placeholder="<? echo lang("login_password_label"); ?>" class="login password-field"/>
						
						<?php
							if( !empty( $AccountPasswordError ) )
								echo "<span class='error' style='display: inline;'>That password is incorrect. <a href="#" style="color: #CCC;">Reset it?</a></span>";
						?>
					</div>
				</div>
			</div>
			
			<div class="login-actions">
				<span class="login-checkbox">
					<input id="Field" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field"><? echo lang("login_remember_label"); ?></label>
				</span>
				
				<button class="button btn btn-warning btn-large"><? echo lang("login_submit_btn"); ?></button>
			</div>
		</form>
	</div>
</div>
