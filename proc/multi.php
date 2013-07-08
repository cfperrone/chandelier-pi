<?php

require_once('base.php');
require_once('loader.php');
setthreadtitle('php-chan-multi');

$config = new Config();
$pin_red = $config->get('pin_red', -1);
$pin_green = $config->get('pin_green', -1);
$pin_blue = $config->get('pin_blue', -1);

$pins = array('red' => $pin_red, 'green' => $pin_green, 'blue' => $pin_blue);
$config = $config->get('multi_array', array(array('red' => 0, 'green' => 0, 'blue' => 0, 'wait' => 1, 'hold' => 1)));

$pwm = new PWM();
$pwm->clearAll();

// ramp up to first color
for ($j = 0; $j <= 1; $j += 0.01) {
    $value = pow($j, 2);

    $red = $value * ((float)$config[0]['red']);
    $green = $value * ((float)$config[0]['green']);
    $blue = $value * ((float)$config[0]['blue']);

    set($pwm, $pins, $red, $green, $blue);
    usleep($config[0]['hold']*1000);
}

usleep($config[0]['wait']);

while(true) {
    for ($i = 0; $i < count($config); $i++) {
        $rgb0 = $config[$i];
        $rgb1 = $config[($i+1)%count($config)];

        set($pwm, $pins, $rgb0['red'], $rgb0['green'], $rgb0['blue']);

        for ($j = 0; $j <= 1; $j += 0.01) {
            $value = $j;
            $inv = 1 - $j;

            $red = ($inv * ((float)$rgb0['red'])) +
                   ($value * ((float)$rgb1['red']));
            $green = ($inv * ((float)$rgb0['green'])) +
                     ($value * ((float)$rgb1['green']));
            $blue = ($inv * ((float)$rgb0['blue'])) +
                    ($value * ((float)$rgb1['blue']));

            set($pwm, $pins, $red, $green, $blue);
            usleep($rgb0['hold']*1000);
        }

        usleep($rgb0['wait']*1000);
    }
}

function set($pwm, $pins, $red, $green, $blue) {
    $pwm->writePinMultiple(array(
        $pins['red'] => min($red / 255, 1),
        $pins['green'] => min($green / 255, 1),
        $pins['blue'] => min($blue / 255, 1),
    ));
}
