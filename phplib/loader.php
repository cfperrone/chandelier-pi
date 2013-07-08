<?php

/* this is the loader of phplib */

// for debugging errors
ini_set('display_errors', '1');
error_reporting(E_ALL);

// autoload any classes referenced
function autoloadClass($class_name) {
	// if it's a finder, then include it's parent class
	if (strlen($class_name) > 6 && substr($class_name, strlen($class_name)-6) == 'Finder') {
		$class_name = substr($class_name, 0, strlen($class_name)-6);
	}
	
	$class_path = str_replace('_', '/', $class_name);
    $full_path = $class_path . ".php";
	require_once $full_path;
}

// include the smarty module
require_once('Smarty/Smarty.php');

// register the autoload function
spl_autoload_register("autoloadClass");



