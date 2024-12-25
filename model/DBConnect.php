<?php
class DBConnect {
    private static $instance = null;
    private $db; 

    private function __construct()
    {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->db = new PDO("mysql:host=localhost;dbname=pico_sbs", "root", "", $options);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }
}