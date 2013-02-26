<?php
	//Standard Includes
	include("includes/global.php");

	$request = $ROUTER->routeInfo();

	if(empty($request['args'][1])) {
		//Nothing to show load appropriate main page.
	}
?>