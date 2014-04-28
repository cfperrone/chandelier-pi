<?php

require_once('base.php');
require_once('loader.php');
setthreadtitle('php-chan-pulse');

$config = new Config();
$pin_red = $config->get('pin_red', -1);
$pin_green = $config->get('pin_green', -1);
$pin_blue = $config->get('pin_blue', -1);
$sleep_time = $config->get('pulse_wait_time', 0) * 1000;
$hold_time = $config->get('pulse_hold_time', 0) * 1000 * 10;
$pulse_rgb = $config->get('pulse_rgb', array('red' => 255, 'green' => 255, 'blue' => 255));

$pwm = new PWM();
$pwm->clearAll();

while(true) {
    for ($j = 0; $j <= 100; $j++) {
        $value = pow(((float)$j)/100, 2);

        $arr = array(
            $pin_red => $value * (((float)$pulse_rgb['red'])/255),
            $pin_green => $value * (((float)$pulse_rgb['green'])/255),
            $pin_blue => $value * (((float)$pulse_rgb['blue'])/255),
        );

        $pwm->writePinMultiple($arr);

        usleep($sleep_time);
    }

    usleep($hold_time);

    for ($j = 100; $j >= 0; $j--) {
        $value = pow(((float)$j)/100, 2);

        $arr = array(
            $pin_red => $value * (((float)$pulse_rgb['red'])/255),
            $pin_green => $value * (((float)$pulse_rgb['green'])/255),
            $pin_blue => $value * (((float)$pulse_rgb['blue'])/255),
        );

        $pwn->writePinMultiple($arr);

        usleep($sleep_time);
    }

    usleep($hold_time);
}
