<?php

class PWM {

    // the PWM output file. this should be writeable already
    const PWM_FILE = "/dev/pi-blaster";

    const PIN_MIN = 4;
    const PIN_MAX = 25;
    const VALUE_MIN = 0;
    const VALUE_MAX = 1;
    const MOSFET_TYPE = 'n';

    private $validPins = array(4, 17, 18);

    public function __construct($pinArr=null) {
        // set an array of valid pins either passed in or default
        if (!$pinArr || !is_array($pinArr)) {
            $this->validPins = array(4, 17, 18);
        } else {
            $this->validPins = $pinArr;
        }
    }

    /**
     * Writes the specified value to the specified pin
     * @arg int $pin - the pin to write the value - (0-7)
     * @arg float $value - the pwm value (min: 0, max: 1)
     **/
    public function writePin($pin, $value) {
        $this->validate($pin, $value);
        self::write($pin, $value);
    }

    /**
     * Writes an array of pin=>value pairs. This saves an non-insignificant amount of time
     * @arg array[$int] float - the key value pair of pins to values
     */
    public function writePinMultiple($arr) {
        foreach ($arr as $pin=>$value) {
            $this->validate($pin, $value);
        }
        self::writeMultiple($arr);
    }

    private function validate($pin, $value) {
        if ($pin < self::PIN_MIN || $pin > self::PIN_MAX) {
            throw new Exception("The pin ($pin) is outside of the valid range.");
        }
        if ($value < self::VALUE_MIN || $value > self::VALUE_MAX) {
            throw new Exception("The value ($value) is outside of the valid range.");
        }
        if (!in_array($pin, $this->validPins)) {
            throw new Exception("The pin specified is disabled for this instance of PWM.");
        }
    }

    /**
     * Writes all 0s to the PWM pins
     */
    public function clearAll() {
        foreach ($this->validPins as $pin) {
            self::write($pin, self::VALUE_MIN);
        }
    }

    /**
     * Static function that actually does the file writing.
     * Note: This function does NOT check for valid pin/value combinations
     * @arg int $pin -- the pin to write the value
     * @arg float $value -- the pwm value
     **/
    private static function write($pin, $value) {
        if (self::MOSFET_TYPE == 'p') {
            $outstring = $pin . "=" . (1 - $value);
        } else {
            $outstring = $pin . "=" . $value;
        }

        /* apparently we can't write to a fifo buffer like this in php. */
        /*if (!$handle = fopen(self::PWM_FILE, 'w')) {
            throw new Exception("Could not open PWM FIFO for writing!");
        }
        stream_set_blocking($handle, 0);
        if (fwrite($handle, $outstring) === FALSE) {
            pclose($handle);
            throw new Exception("Could not write new value to PWM FIFO!");
        }
        fpassthru($handle);
        fclose($handle);*/

        exec("echo \"$outstring\" > " . self::PWM_FILE);
    }
    private static function writeMultiple($arr) {
        $outstrings = "";
        foreach ($arr as $pin=>$value) {
            if (self::MOSFET_TYPE == 'p') {
                $outstrings[] = $pin . "=" . (1 - $value);
            } else {
                $outstrings[] = $pin . "=" . $value;
            }
        }
        $outstring = implode("\n", $outstrings);

        exec("echo \"$outstring\" > " . self::PWM_FILE);
    }
}
