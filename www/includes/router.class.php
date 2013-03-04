<?php

	class Router {

		private $error = false;
		private $server;
		private $pathInfo;
		private $clientInfo;
		private $routes;
		
		function __construct() {
			$this->server = $_SERVER['SERVER_NAME'];
			$this->pathInfo = explode("/",$_SERVER['REQUEST_URI']);
			$this->clientInfo['ip'] = $_SERVER['REMOTE_ADDR'];
		}
		
		public function routeInfo() {
			$items = count($this->pathInfo)-1;
			$parsedName = $this->pathInfo[1];
			
			$arr = array("server" => $this->server, "id" => $parsedName);
			
			if($items > 0) {
				$arr2 = array();
				
				for ($i = 1; $i <= $items; $i++) {
					$arr2[$i-1] = $this->pathInfo[$i];
				}
				
				$arr['args'] = $arr2;
			}
			
			return $arr;
		}
		
		public function checkExtension($var) {
			$ext = explode(".",$var);
			if (!empty($ext[1])) {
				switch($ext[1]) {
					case "png":
						return true;
					case "jpg":
						return true;
					case "jpeg":
						return true;
					case "gif":
						return true;
					default:
						return false;
				}
			}
			return false;
		}
	}