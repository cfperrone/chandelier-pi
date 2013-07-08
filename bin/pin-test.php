<?php

require_once('phplib/PWM.php');

$stime = microtime(true);
$pwm = new PWM();
$pwm->clearAll();

if ($argc == 3) {
    $pwm->writePin($argv[1], $argv[2]);
    $etime = microtime(true);
    echo "OK. SET PIN " . $argv[1] . " to " . $argv[2] . " in " . ($etime - $stime) . "s \n";
}
