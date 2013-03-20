<?php
$validate = array();
//no multi-logins, sir.
if ($USER->loaded()) {
	$validate["email"] = "You are already logged in.";
	$validate["password"] = "";
	echo json_encode($validate);
	die();
}

list($pass, $err) = $USER->authenticate($G['email'], $G['password']);
	
if ($pass) {
	$USER->setSession(); //offically 'login'
	echo "true";
} else {
	if ($err == 1) {
		$validate["email"] = "Email not registered!";
	} elseif ($err == 2) {	
		$validate["password"] = "Invalid password!";
	}
	echo json_encode($validate);
}
