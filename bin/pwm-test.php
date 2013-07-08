<?php

require_once('../phplib/PWM.php');

const PIN_RED = 1;
const PIN_GREEN = 2;
const PIN_BLUE = 4;
const SLEEP_TIME_US = 0;
const HOLD_TIME_US = 0;

$pwm = new PWM();
$pwm->clearAll();

for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j <= 100; $j++) {
        $value = ((float)$j)/100;
        $pwm->writePin(PIN_RED, $value);
        $pwm->writePin(PIN_GREEN, $value);
        $pwm->writePin(PIN_BLUE, $value);
        usleep(SLEEP_TIME_US);
    }

    usleep(HOLD_TIME_US);

    for ($j = 100; $j >= 0; $j--) {
        $value = ((float)$j)/100;
        $pwm->writePin(PIN_RED, $value);
        $pwm->writePin(PIN_GREEN, $value);
        $pwm->writePin(PIN_BLUE, $value);
        usleep(SLEEP_TIME_US);
    }

    usleep(HOLD_TIME_US);
}
