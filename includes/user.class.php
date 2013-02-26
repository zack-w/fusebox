<?php

	class User {
		private $uid;
		private $username;
		private $email;
		private $joindate;
		private $sessionData;
		private $cookieTitle = "SFLogin";

		/* Construct class */
			//If you define a user, then it loads it otherwise blank.
		public function __construct($uid = null, $cooktitle = null) {
			if ($uid) {
				$this->load($uid);
			}

			if($cookieTitle) {
				$this->cookieTitle = $cooktitle;
			}
		}
		
		public function load($uid) {
			global $DB;
			if ($user = $DB->queryRow("SELECT * FROM users WHERE uid='".$DB->escape($uid))."'") {
				$this->uid = $user['uid'];
				$this->username = $user['username'];
				$this->email = $user['email'];
				$this->joindate = $user['timestamp'];
				$this->flags = explode(",", $user['flags']);
			} else {
				exit("Invalid UID Specified");
			}
		}
		
		/* Find */
		
		public function getByName($user) {
			global $DB;
			return $DB->queryRow("SELECT * FROM users WHERE username='".$DB->escape($user)."'");
		}
		
		public function getByEmail($user) {
			global $DB;
			return $DB->queryRow("SELECT * FROM users WHERE email='".$DB->escape($user)."'");
		}
		
		/* Authentication */
		
		public function authenticate($email, $pass) {
			global $DB;
			$email = $DB->escape($email);
			if ($userData = $this->getByEmail($email)) {
				$pass = $this->hashPassword($pass, $userData['timestamp']);
				if ($userData['password'] == $pass) {
					$this->load($userData['uid']);
					return array(true, 0);
				} else {
					return array(false, 2);
				}
			} else {
				return array(false, 1);
			}
		}
		
		public function getSession() {
			global $DB;
			$cookie = $this->getCookie();
			if (!empty($cookie)) {
				$sessid = $DB->escape($this->getCookie());
				$sessData = $DB->queryRow("SELECT * FROM sessions WHERE sessionid='".$sessid."'");
				$this->sessionData = $sessData;
				$this->load($sessData['uid']);
				return true;
			} else {
				return false;
			}
		}
		
		public function deleteSession() {
			global $DB;
			$cookie = $this->getCookie();
			$DB->query("DELETE FROM sessions WHERE sessionid='".$DB->escape($cookie)."'");
			setcookie($cookieTitle, "", time() - 3600*24*30*12, "/");
		}
		
		public function loaded() {
			return !empty($this->uid);
		}
		
		public function isAdmin() {

			if(array_search("a", $this->flags) === false)
				return false;
			else
				return true;
		}

		public function hasFlag($flag = null) {
			if(array_search($flag, $this->flags) === false)
				return false;
			else
				return true;
		}
		
		// Sets a session to the current user and saves the cookie!
		public function setSession() {
			global $DB;
			$sessid = $this->generateSessionKey();
			$time = time();
			$DB->query("INSERT INTO sessions (sessionid, uid, ip, timestamp) VALUES ('".$sessid."', '".$this->uid."', '".$_SERVER['REMOTE_ADDR']."', ".$time.")");
			$this->setCookie($sessid);
		}
		
		public function generateSessionKey() {
			return md5($this->uid.$_SERVER['REMOTE_ADDR'].time());
		}
		
		public function setCookie($data) {
			setcookie($cookieTitle, $data, time() + 3600*24*30*12, "/");
		}
		
		public function getCookie() {
			if (!empty($_COOKIE[$cookieTitle])) {
				return $_COOKIE[$cookieTitle];	
			} else {
				return "";
			}
		}
		
		/* User Options! */
		
		public function getOption($key, $default = false) {
			global $DB;
			$key = $DB->escape($key);
			if ($data = $DB->queryRow("SELECT * FROM users_settings WHERE uid='".$this->uid."'' AND okey='".$key."'")) {
				return $data['ovalue'];
			} else {
				if ($default) {
					$this->setOption($key, $default);
				}
				return $default;
			}
		}
		
		public function setOption($key, $value) {
			global $DB;
			$key = $DB->escape($key);
			$value = $DB->escape($value);
			if ($DB->queryRow("SELECT * FROM users_settings WHERE uid='".$this->uid."'' AND okey='".$key."'")) {
				$DB->query("UPDATE users_settings SET ovalue='".$value."' WHERE uid='".$this->uid."'' AND okey='".$key."'");
			} else {
				$DB->query("INSERT INTO users_settings (uid, okey, ovalue) VALUES ('".$this->uid."', '".$key."', '".$value."')");
			}
		}	
		
		/* Get Set Methods */
		
		public function getUID() {
			return $this->uid;
		}
		
		public function getName() {
			return $this->username;
		}
		
		public function getEmail() {
			return $this->email;
		}
		
		public function getJoindate() {
			return $this->joindate;
		}
		
		/* Registration Related */
		
		public function usernameExists($test) {
			global $DB;
			return ($DB->countRows("SELECT * FROM users WHERE username='".$DB->escape($test)."'") > 0);
		}
		
		public function emailUsed($test) {
			global $DB;
			return ($DB->countRows("SELECT * FROM users WHERE email='".$DB->escape($test)."'") > 0);
		}
		
		public function hashPassword($password, $time) { //Timestamp will act like a salt, as well as constant appended text.
			return md5("pw-".$password.$time);
		}
		
		public function registerUser($user, $password, $email) {
			global $DB;
			$time = time();
			$user = $DB->escape($user);
			$password = $this->hashPassword($password, $time);
			$email = $DB->escape($email);
			if ($DB->query("INSERT INTO users (username, password, email, timestamp, flags) VALUES ('".$user."', '".$password."', '".$email."', '".$time."', '')")) {
				$this->uid = mysql_insert_id();
				$this->username = $user;
				$this->email = $email;
				$this->joindate = $time;
				return true;
			}
			return false;
		}
		
		public function validateEmail($email) {
			return filter_var($email, FILTER_VALIDATE_EMAIL);
		}
	}
?>