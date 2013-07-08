<?php

class DAO extends PDO {
    private $fetch_mode = PDO::FETCH_ASSOC;

    function __construct() {
        // db and creds
        $host = Config::DB_HOST;
        $dbname = Config::DB_NAME;
        $user = Config::DB_USER;
        $pass = Config::DB_PASS;

        parent::__construct("mysql:host=${host};dbname=${dbname}", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    public function setFetchMode($fetch_mode) {
        $this->fetch_mode = $fetch_mode;
    }

    public function query($sql, $fetch = PDO::FETCH_ASSOC) {
        $stmt = parent::query($sql, $fetch);
        if ($stmt) {
            $stmt->setFetchMode($fetch);
        }
        return $stmt;
    }

    public function getConfig() {
        $query = $this->prepare(
            "SELECT * FROM config");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getValueFromKey($key) {
        $query = $this->prepare(
            "SELECT `value` FROM config WHERE `key` = ?");
        $query->execute(array($key));
        return $query->fetchColumn();
    }

    public function replicateConfig($key, $value) {
        $existing = $this->getValueFromKey($key);

        if (is_array($value)) {
            $value = json_encode($value);
        }
        if ($existing) {
            // do an update
            $query = $this->prepare(
                "UPDATE config
                SET `value`=?
                WHERE `key`=?");
            $query->execute(array($value, $key));
        } else {
            // do an insert
            $query = $this->prepare(
                "INSERT INTO config
                 (`key`, `value`) VALUES
                 (?, ?)");
            $query->execute(array($key, $value));
        }
    }

    public function deleteConfigByKey($key) {
        $query = $this->prepare(
            "DELETE FROM config WHERE `key`=?");
        $query->execute(array($key));
    }
}
