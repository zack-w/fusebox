<!DOCTYPE html>
<html lang="en">
  <head>
	 <meta charset="utf-8">
	 <title><?php echo $title; ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	 <meta name="apple-mobile-web-app-capable" content="yes"> 
	 
	<link href="<? echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
	<link href="<? echo base_url("assets/css/bootstrap-responsive.min.css"); ?>" rel="stylesheet" type="text/css" />

	<link href="<? echo base_url("assets/css/font-awesome.css"); ?>" rel="stylesheet">
	 <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
	 
	<link href="<? echo base_url("assets/css/base-admin.css"); ?>" rel="stylesheet" type="text/css">
	<link href="<? echo base_url("assets/css/pages/signin.css"); ?>" rel="stylesheet" type="text/css">

	<script src="<? echo base_url("assets/js/jquery-1.7.2.min.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/forms.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/excanvas.min.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.flot.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.flot.pie.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.flot.orderBars.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.flot.resize.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/bootstrap.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/base.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/charts/area.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/charts/donut.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.tools.js"); ?>"></script>
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
				
				<a class="brand" href="<?php echo base_url(); ?>">
					<? echo $general_display_name; ?>		
				</a>		
				
				<div class="nav-collapse">
					<ul class="nav pull-right">
						<li class="dropdown">
							
							<? if (!$login) { ?>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-cog"></i>
										<?php echo lang('base_page_login')."/".lang('base_page_register'); ?>
									<b class="caret"></b>
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="<? echo base_url("user/login"); ?>"><?php echo lang('base_page_login'); ?></a></li>
									<li><a href="<? echo base_url("user/register"); ?>"><?php echo lang('base_page_register'); ?></a></li>
								</ul>
							<? } else { ?>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-cog"></i>
									<? echo $user->username; ?>
									<b class="caret"></b>
								</a>
								
								<ul class="dropdown-menu">
									<li><a href="<? echo base_url("user"); ?>">User CP</a></li>
									<li><a href="<? echo base_url("user/logout"); ?>">Logout</a></li>
								</ul>
							<? } ?>
							
						</li>
						<li><a href-"http://slidefuse.com/Fusebox">Fusebox : 1.0</a></li>
					</ul>
				</div>	
		
			</div> <!-- /container -->
			
		</div> <!-- /navbar-inner -->
		
	</div> <!-- /navbar -->