<?php
class Database {
    private static $instance;
    private $conn;

    private $host = '127.0.0.1';
    private $username = 'root';
    private $password = '';
    private $database = 'sushirestoraunt';
    private $port = '3306';

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database,$this->port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>