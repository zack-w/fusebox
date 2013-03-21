<?php
	$page_title = "Login";
?>

<div class="account-container">
	
	<div class="content clearfix">
		
		<form id="login" method="post" action="#">
		
			<h1>Sign In</h1>		
			
			<div class="login-fields">
				
				<p>Sign in using your registered account:</p>
				
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
									
				<button class="button btn btn-warning btn-large">Sign In</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

<script type="text/javascript">
	$(function () {	
		$("#login").validator().submit(function(e) {
			var form = $(this);
			console.log("Logging in...");
			if (!e.isDefaultPrevented()) {
				console.log("Not prevented!");
				console.log("<?php echo $BASEURL; ?>api/ajax.php?a=login&" + form.serialize());
				$.getJSON("<?php echo $BASEURL; ?>api/ajax.php?a=login&" + form.serialize(), function(json) {
					console.log("Got Data!");
					console.log(json);
					if (json === true)  {
						location.href = "<?php echo $BASEURL; ?>";
					} else {
						console.log("Invalid, gutting out.");
						form.data("validator").invalidate(json);
					}
				});
				e.preventDefault();
			}
		});
	});
</script>