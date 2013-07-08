<?php

/* This deals with the api requests */
class HTTP_Request {
	private $getVars;
	private $postVars;
    private $cookies;
	
	private static $__instance;

	public function __construct() {
		$this->getVars = array();
		$this->postVars = array();
        $this->cookies = array();
		
		// save the get vars
		foreach ($_GET as $key => $value) {
			$this->getVars[$key] = $value;
		}
		
		// save the post vars
		foreach ($_POST as $key => $value) {
			$this->postVars[$key] = $value;	
		}

        // save the cookies
        foreach ($_COOKIE as $key => $value) {
            $this->cookies[$key] = $value;
        }
	}
	
	public function getGet($name, $default) {
		if (array_key_exists($name, $this->getVars)) {
			return $this->getVars[$name];	
		} else {
			return $default;
		}
	}
	
	public function getPost($name, $default) {
		if (array_key_exists($name, $this->postVars)) {
			return $this->postVars[$name];	
		} else {
			return $default;
		}
	}

    public function getCookie($name, $default) {
        if (array_key_exists($name, $this->cookies)) {
            return $this->cookies[$name];
        } else {
            return $default;
        }
    }

    public function isPost() {
        return ($this->getMethod() === 'POST');
    }

    public function isGet() {
        return ($this->getMethod() === 'GET');
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
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
