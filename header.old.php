<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FuseBox</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="<? echo $BASEURL; ?>cogs/css/bootstrap.css" rel="stylesheet">
		<link href="<? echo $BASEURL; ?>cogs/css/4strap.css" rel="stylesheet">

		<!--<link href="cogs/css/bootstrap-responsive.css" rel="stylesheet">!-->
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="<? echo $BASEURL; ?>cogs/ico/favicon.ico">
		
		
		<script src="<? echo $BASEURL; ?>cogs/js/jquery.js"></script>
		<script src="<? echo $BASEURL; ?>cogs/js/bootstrap-dropdown.js"></script>

		<script src="<? echo $BASEURL; ?>cogs/js/jquery.tools.js"></script>
		<script src="<? echo $BASEURL; ?>cogs/js/forms.js"></script>
		
		<link href='http://fonts.googleapis.com/css?family=Istok+Web:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
		
		
	</head>
	<body>
 
  
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<div class="pull-right">
						<? if ($USER->loaded()) { ?>
							<div class="btn">
								<a href="<? echo $BASEURL; ?>logout"><i class="icon-off"></i> Logout</a>
							</div>

							<b><? echo $PRODUCTTITLE." ".$PRODUCTVERSION; ?></b>	
						<? } ?>
						
						
						
					</div>
					
					
					<ul class="nav">
						<li>
							<a href="<? echo $BASEURL; ?>" style="padding: 0;"><img src="<? echo $BASEURL; ?>cogs/img/logo.png"></a>
						</li>
						
						<li class="divider-vertical"></li>
						
						<li>
							<? if ($USER->loaded()) { ?>
								<div class="btn">
									<a href="<? echo $BASEURL; ?>account"><i class="icon-wrench"></i> <? echo $USER->getName(); ?>'s Account</a>
								</div>
								<div class="btn">
									<a href="<? echo $BASEURL; ?>gallery"><i class="icon-th"></i> My Gallery (<? echo $GALLERY->numImages(); ?>)</a>
								</div>
								<!--
								<div class="btn">
									<a href="<? echo $BASEURL; ?>pastes"><i class="icon-edit"></i> My Pastes</a>
								</div>
								!-->
								
							<? } else { ?>
								
							<? } ?>
						</li>
					</ul>
				

				</div>
			</div>
		</div>
