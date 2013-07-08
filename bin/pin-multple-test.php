<?php

require_once('phplib/PWM.php');

$stime = microtime(true);
$pwm = new PWM();
$pwm->clearAll();

if ($argc == 2) {

    $arr = array(1 => $argv[1], 2 => $argv[1], 4 => $argv[1]);
    $pwm->writePinMultiple($arr);
    $etime = microtime(true);
    echo "OK. SET PINS TO " . $argv[1] . " in " . ($etime - $stime) . "s \n";
}
