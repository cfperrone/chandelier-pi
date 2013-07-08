<?php

/* This deals with the HTTP Response
	ALL responses sent to the browser should go through this class */
class HTTP_Response {
	private static $__instance;
	
	public function redirect($url) {
        header("Location: $url");
	}
	
	public static function SEND_JSON($arr) {
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-type: application/json');
		echo json_encode($arr);
	}
	
	public function sendJSON($arr) {
		self::SEND_JSON($arr);	
	}
	
	// gets a singleton of the instance
	public static function getInstance() {
		if (!self::$__instance) {
			$c = __CLASS__;
			self::$__instance = new $c();
		}
		return self::$__instance;
	}
	
}
