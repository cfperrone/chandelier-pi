<?php

require_once('loader.php');

$config = new Config();
$proc = new Proc($config);

if ($argc != 2) {
    echo "You must specify a function to run as the first argument.\n";
    echo "The available functions are: " . json_encode($config->get('available_functions', array())) . "\n";
    die;
}

$proc->runFunction($argv[1]);
