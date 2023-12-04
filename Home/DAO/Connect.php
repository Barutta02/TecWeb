<?php
class Database {
    private static $conn;

    private static $host = '127.0.0.1';
    private static $username = 'root';
    private static $password = '';
    private static $database = 'sushirestaurant';
    private static $port = '3306';

    private function __construct() {
        
    }

    public static function getInstance() {
        if (self::$conn === null) {
            self::$conn = new mysqli( self::$host,  self::$username,  self::$password,  self::$database,  self::$port);
            if ( self::$conn->connect_error) {
                die("Connection failed: " .  self::$conn->connect_error);
            }
        }
        return self::$conn;
    }

}


?>