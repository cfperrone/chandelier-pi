<?php

/* CAUTION -- please note
 * This file cannot be run as a standalone process. However, it MUST be included
 * at the top of every runnable process for the chandelier. If you add a process,
 * add "require_once('base.php');" to the top of the file. Otherwise, the process
 * can run but cannot be killed gracefully. This could possibly cause some issues...
 */

declare(ticks = 1);
ignore_user_abort(true);

// signal handler function
function sig_handler($signo) {
    switch ($signo) {
        case SIGTERM:
            $term_pwm = new PWM();
            $term_pwm->clearAll();
            exit;
            break;
        case SIGHUP:
        case SIGUSR1:
            echo "Some crazy advanced functionality...\n";
            break;
        default:
            break;
    }
}

// install the signal handler functions
pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGHUP, "sig_handler");
pcntl_signal(SIGUSR1, "sig_handler");

// create a shutdown function for processes which do not run forever
// this is primarily for configuration pid cleanup
function shutdown () {
    //$config = new Config();
    //$config->unsetKey('pid');
}

// install the shutdown function
register_shutdown_function('shutdown');
