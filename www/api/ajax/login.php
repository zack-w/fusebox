<?php
$validate = array();
//no multi-logins, sir.
if ($USER->loaded()) {
	$validate["username"] = "You are already logged in.";
	$validate["password"] = "";
	echo json_encode($validate);
	die();
}

list($pass, $err) = $USER->authenticate($G['username'], $G['password']);
	
if ($pass) {
	$USER->setSession(); //offically 'login'
	echo "true";
} else {
	if ($err == 1) {
		$validate["username"] = "Username not registered!";
	} elseif ($err == 2) {	
		$validate["password"] = "Invalid password!";
	}
	echo json_encode($validate);
}
