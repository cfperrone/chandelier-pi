<?php

require_once('base.php');
require_once('loader.php');
setthreadtitle('php-chan-solid');

$config = new Config();
$pin_red = $config->get('pin_red', -1);
$pin_green = $config->get('pin_green', -1);
$pin_blue = $config->get('pin_blue', -1);
$solid_rgb = $config->get('solid_rgb', array('red' => 255, 'green' => 255, 'blue' => 255));

$pwm = new PWM();
$pwm->clearAll();

while (true) {
    $red_value = (((float)$solid_rgb['red'])/255);
    $green_value = (((float)$solid_rgb['green'])/255);
    $blue_value = (((float)$solid_rgb['blue'])/255);

    $arr = array(
        $pin_red => $red_value,
        $pin_green => $green_value,
        $pin_blue => $blue_value,
    );

    $pwm->writePinMultiple($arr);

    sleep(1);
}
