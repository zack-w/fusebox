<?php
	//Standard Includes
	include("includes/global.php");

	$request = $ROUTER->routeInfo();
	if(empty($request['args'][2])) {
		//Nothing to show load appropriate main page.
		if (!$USER->loaded()) { 
			header("location: ".$BASEURL."login");
		} else {
			//User is logged in, show dashboard.
			include($BASEPATH."partials/header.php");
			include($BASEPATH."partials/dashboard.php");
			include($BASEPATH."partials/footer.php");
		}
	} else {
		//Process argument
		include($BASEPATH."partials/header.php");

		if(file_exists($BASEPATH."partials/".$request['args'][2].".php")) {
			require($BASEPATH."partials/".$request['args'][2].".php");
		} else
			die("Could not process your request.");	

		include($BASEPATH."partials/footer.php");
	}
?>