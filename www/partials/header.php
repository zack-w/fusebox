<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><!--TITLE--></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
	<link href="<? echo $BASEURL; ?>cogs/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<? echo $BASEURL; ?>cogs/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

	<link href="<? echo $BASEURL; ?>cogs/css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
	<link href="<? echo $BASEURL; ?>cogs/css/base-admin.css" rel="stylesheet" type="text/css">
	<link href="<? echo $BASEURL; ?>cogs/css/pages/signin.css" rel="stylesheet" type="text/css">

	<script src="<? echo $BASEURL; ?>cogs/js/jquery-1.7.2.min.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/forms.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/excanvas.min.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/jquery.flot.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/jquery.flot.pie.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/jquery.flot.orderBars.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/jquery.flot.resize.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/bootstrap.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/base.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/charts/area.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/charts/donut.js"></script>
	<script src="<? echo $BASEURL; ?>cogs/js/jquery.tools.js"></script>
</head>

<body>

<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="<?php echo $BASEURL; ?>">
				<?php echo $SETTINGS->get("general_display_name"); ?>			
			</a>		

			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="dropdown">
						
						<? if (!$USER->loaded()) { ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-cog"></i>
								Login/Register
								<b class="caret"></b>
							</a>
							
							<ul class="dropdown-menu">
								<li><a href="<? echo $BASEURL."login"; ?>">Login</a></li>
								<li><a href="<? echo $BASEURL."register"; ?>">Register</a></li>
							</ul>
						<? } else { ?>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-cog"></i>
								<? echo $user->username; ?>
								<b class="caret"></b>
							</a>
							
							<ul class="dropdown-menu">
								<li><a href="<? echo $BASEURL."account"; ?>">My Account</a></li>
								<li><a href="<? echo $BASEURL."logout"; ?>">Logout</a></li>
							</ul>
						<? } ?>
						
					</li>
					<li><a href-"http://slidefuse.com/<?php echo $PRODUCTTITLE; ?>"><?php echo $PRODUCTTITLE." : ".$PRODUCTVERSION; ?></a></li>
				</ul>
			</div>	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->