<?php
	session_start();
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 'On');
	ini_set('html_errors', 'On');
	$BASEPATH = "/Applications/MAMP/htdocs/fusebox/www/";
	$BASEURL = "http://localhost:8888/fusebox/www/";
	
	//Setup MySQL
	include($BASEPATH."includes/sfql.class.php");
	$DB = new SFQL("localhost","root","root","fusebox");
	
	//Setup Router
	include($BASEPATH."includes/router.class.php");
	$ROUTER = new Router();

?>
