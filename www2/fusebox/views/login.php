<link href="<? echo base_url("assets/css/pages/signin.css"); ?>" rel="stylesheet" type="text/css">

<div class="account-container">
	<div class="content clearfix">
		<form action="<? echo base_url("user/login"); ?>" method="post">
			<h1><?php echo lang("login_heading"); ?></h1>		
			<div class="login-fields">
				
				<p><?php echo lang("login_subheading"); ?></p>
				
				<div class="field">
					<label for="username"><?php echo lang("index_email_th"); ?>:</label>
					<input type="text" id="identity" name="identity" value="" placeholder="<?php echo lang("index_email_th"); ?>" class="login username-field" />
				</div>
				
				<div class="field">
					<label for="password"><?php echo lang("login_password_label"); ?>:</label>
					<input type="password" id="password" name="password" value="" placeholder="<?php echo lang("login_password_label"); ?>" class="login password-field"/>
				</div>
				
			</div>
			
			<div class="login-actions">
				<span class="login-checkbox">
					<input id="Field" name="remember" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field"><?php echo lang("login_remember_label"); ?></label>
				</span>		
				<button class="button btn btn-warning btn-large"><?php echo lang("login_submit_btn"); ?></button>
			</div>
		</form>
	</div>
</div>