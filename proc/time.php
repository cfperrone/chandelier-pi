<?php

require_once('base.php');
require_once('loader.php');
setthreadtitle('php-chan-solid');

$config = new Config();
$pin_red = $config->get('pin_red', -1);
$pin_green = $config->get('pin_green', -1);
$pin_blue = $config->get('pin_blue', -1);

$midnight = array('red' => 0, 'green' => 0, 'blue' => 30);
$noon = array('red' => 255, 'green' => 100, 'blue' => 0);

$pwm = new PWM();
$pwm->clearAll();

while (true) {
    $now = (int)date("G") + (int)date("i");

    if ($now < 720) {
        $red = abs($midnight['red'] - $noon['red'])*($now/1440);
        $green = abs($midnight['green'] - $noon['green'])*($now/1440);
        $blue = abs($midnight['blue'] - $noon['blue'])*($now/1440);
    } else {
        $red = abs($noon['red'] - $midnight['red'])*($now/1440);
        $green = abs($noon['green'] - $midnight['green'])*($now/1440);
        $blue = abs($noon['blue'] - $midnight['blue'])*($now/1440);
    }
    $red_value = (((float)$red)/255);
    $green_value = (((float)$green)/255);
    $blue_value = (((float)$blue)/255);

    $pwm->writePin($pin_red, $red_value);
    $pwm->writePin($pin_green, $green_value);
    $pwm->writePin($pin_blue, $blue_value);

    sleep(1);
}
