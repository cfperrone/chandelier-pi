<?php

class Config {
    const CONFIG_FILE_PATH = "/home/pi/www/chandelier/tmp/chandelier-config";

    const DB_HOST = 'localhost';
    const DB_NAME = 'chandelier';
    const DB_USER = 'root';
    const DB_PASS = '';

    /* the config object decoded */
    private $config;
    private $dao;

    public function __construct() {
        $this->dao = new DAO();
        try {
            $this->config = $this->readConfigSQL();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * This function creates a new config file with default values
     * and saves it to the specified config file location
     */
    public function createNew() {
        $canfig = array(
            'available_functions' => array('off', 'solid', 'pulse', 'dual', 'multi', 'time'),
            'function' => 'off',

            'pin_red' => 4,
            'pin_green' => 17,
            'pin_blue' => 18,
        );
        $this->setArray($config);
    }

    /**
     * Retrieves the value specified by $key from configuration.
     * Returns $default if the key doesn't exist.
     */
    public function get($key, $default) {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        } else {
            return $default;
        }
    }

    /**
     * Returns the entire config array. This is primarily used for debugging.
     * Note: This shouldn't be used for reading values from configuration!
     */
    public function getAll() {
        return $this->config;
    }

    /**
     * Sets the $value in the config array for given $key.
     * Config is always written once a new value is set
     */
    public function set($key, $value) {
        //self::writeConfig($this->config);
        $this->writeConfigSQL($key, $value);

        // re-hydrate the array
        $this->config = $this->readConfigSQL();
    }

    public function setArray($map) {
        foreach ($map as $key => $value) {
            $this->writeConfigSQL($key, $value);
        }

        // re-hydrate the array
        $this->config = $this->readConfigSQL();
    }

    public function unsetKey($key) {
        unset($this->config[$key]);
        $this->dao->deleteConfigByKey($key);
    }

    /* STATIC CONFIG FUNCTIONS BELOW */
    private function readConfigSQL() {
        $config = $this->dao->getConfig();

        $decoded = array();
        foreach ($config as $row) {
            $value = json_decode($row['value'], true);
            if ($value === null) {
                $value = $row['value'];
            }
            $decoded[$row['key']] = $value;
        }
        return $decoded;
    }

    private function writeConfigSQL($key, $value) {
        $this->dao->replicateConfig($key, $value);
    }

    private function readConfigFile() {
        if (!file_exists(self::CONFIG_FILE_PATH) || filesize(self::CONFIG_FILE_PATH) == 0) {
            throw new ConfigNotFoundException("The config file could not be found");
        }

        if (!$handle = fopen(self::CONFIG_FILE_PATH, 'r')) {
            throw new Exception("The config file could not be open for reading");
        }

        $contents = fread($handle, filesize(self::CONFIG_FILE_PATH));
        fclose($handle);

        if (($decoded = json_decode($contents, true)) == null) {
            throw new Exception("The config file contents could not be decoded");
        }

        // replicate to mysql
        foreach ($decoded as $key=>$value) {
            $this->dao->replicateConfig($key, $value);
        }

        return $decoded;
    }

    private function writeConfigFile($config) {
        $config_string = json_encode($config);

        if (!$handle = fopen(self::CONFIG_FILE_PATH, 'w')) {
            throw new Exception("The config file could not be open for writing");
        }

        if (fwrite($handle, $config_string) == false) {
            fclose($handle);
            throw new Exception("Could not write new config to file");
        }

        fclose($handle);

        exec('chmod 777 ' . self::CONFIG_FILE_PATH);
    }
}

class ConfigNotFoundException extends Exception { }
class ConfigValueNotFoundException extends Exception { }
