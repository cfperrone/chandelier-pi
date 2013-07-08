<?php

class Proc {
    const PROC_ROOT = "/home/pi/www/chandelier/proc/";

    private $config;

    public function __construct($config=null) {
        if ($config) {
            $this->config = $config;
        } else {
            $this->config = new Config();
        }
    }

    /**
     * Stops any currently running jobs and runs $function
     */
    public function runFunction($function) {
        $this->stop();

        // check if function is valid
        $all_functions = $this->config->get('available_functions', array());
        if (!in_array($function, $all_functions)) {
            throw new Exception("Function '$function' is unavailable.");
        }

        // check if file actually exists
        $proc_path = self::PROC_ROOT . $function . ".php";
        if (!file_exists($proc_path)) {
            throw new Exception("Function file $proc_path not found.");
        }

        // fork the process
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new Exception("Could not fork process");
        } else if ($pid) {
            // parent process
            $this->config->set('pid', $pid);
            $this->config->set('function', $function);
            return $pid;
        } else {
            // child process
            pcntl_exec("/usr/bin/php", array($proc_path));
            die;
        }
    }

    /**
     * Stops any currently running jobs
     */
    public function stop() {
        $pid = $this->config->get('pid', null);

        if ($pid == null) {
            error_log("PID doesn't exist");
        }

        if ($pid && $pid > 0) {
            if (posix_kill($pid, SIGTERM) || !file_exists("/proc/$pid")) {
                $this->config->unsetKey('pid');
            } else {
                throw new Exception("Could not stop process $pid.");
            }
        }
    }

    public function reset() {
        exec("pkill php-chan*");
    }

}
