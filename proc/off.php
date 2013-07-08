<?php

require_once('loader.php');
setthreadtitle('php-chan-off');

$pwm = new PWM();
$pwm->clearAll();

$config = new Config();
$config->unsetKey('pid');
