<?php
include("../includes/global.php");

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');

$A = $_GET['a'];
$G = $_GET;

if(file_exists($BASEPATH."api/ajax/".$A.".php")) {
	require($BASEPATH."api/ajax/".$A.".php");
} else
	die("Could not process your request.");