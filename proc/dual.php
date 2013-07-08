<?php

require_once('base.php');
require_once('loader.php');
setthreadtitle('php-chan-dual');

$config = new Config();
$pin_red = $config->get('pin_red', -1);
$pin_green = $config->get('pin_green', -1);
$pin_blue = $config->get('pin_blue', -1);
$pins = array('red' => $pin_red, 'green' => $pin_green, 'blue' => $pin_blue);
$sleep_time = $config->get('pulse_wait_time', 1) * 1000;
$hold_time = $config->get('pulse_hold_time', 1) * 1000 * 10;
$dual_rgb_0 = $config->get('dual_rgb_0', array('red' => 255, 'green' => 0, 'blue' => 0));
$dual_rgb_1 = $config->get('dual_rgb_1', array('red' => 0, 'green' => 0, 'blue' => 255));

$pwm = new PWM();
$pwm->clearAll();

// ramp up to first color
for ($j = 0; $j <= 1; $j += 0.01) {
    $value = pow($j, 2);

    $red = $value * ((float)$dual_rgb_0['red']);
    $green = $value * ((float)$dual_rgb_0['green']);
    $blue = $value * ((float)$dual_rgb_0['blue']);

    set($pwm, $pins, $red, $green, $blue);
    usleep($sleep_time);
}

usleep($hold_time);

while(true) {
    set($pwm, $pins, $dual_rgb_0['red'], $dual_rgb_0['green'], $dual_rgb_0['blue']);

    for ($j = 0; $j <= 1; $j += 0.01) {
        $value = $j;
        $inv = 1 - $j;

        $red = ($inv * ((float)$dual_rgb_0['red'])) +
               ($value * ((float)$dual_rgb_1['red']));
        $green = ($inv * ((float)$dual_rgb_0['green'])) +
                 ($value * ((float)$dual_rgb_1['green']));
        $blue = ($inv * ((float)$dual_rgb_0['blue'])) +
                ($value * ((float)$dual_rgb_1['blue']));

        set($pwm, $pins, $red, $green, $blue);
        usleep($sleep_time);
    }

    usleep($hold_time);

    set($pwm, $pins, $dual_rgb_1['red'], $dual_rgb_1['green'], $dual_rgb_1['blue']);

    for ($j = 1; $j >= 0; $j -= 0.01) {
        $value = $j;
        $inv = 1 - $j;

        $red = ($inv * ((float)$dual_rgb_0['red'])) +
               ($value * ((float)$dual_rgb_1['red']));
        $green = ($inv * ((float)$dual_rgb_0['green'])) +
                 ($value * ((float)$dual_rgb_1['green']));
        $blue = ($inv * ((float)$dual_rgb_0['blue'])) +
                ($value * ((float)$dual_rgb_1['blue']));

        set($pwm, $pins, $red, $green, $blue);
        usleep($sleep_time);
    }

    usleep($hold_time);
}

function set($pwm, $pins, $red, $green, $blue) {
    $pwm->writePinMultiple(array(
        $pins['red'] => $red / 255,
        $pins['green'] => $green / 255,
        $pins['blue'] => $blue / 255,
    ));
}
