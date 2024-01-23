<?php

require_once __DIR__ . '/vendor/autoload.php'; 

use Dotenv\Dotenv;

class Database{
  
    public static $connection;

    public static function setUpConnection() {
        if (!isset(Database::$connection)) {

            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $uri = $_ENV["DB_URL"];
            $fields = parse_url($uri);
    
            $conn = new mysqli();
            $conn->ssl_set(NULL, NULL, 'backup/cacert-2023-08-22.pem', NULL, NULL);
            $conn->real_connect($fields["host"], $fields["user"], $fields["pass"], 'cakehub', $fields["port"], NULL, MYSQLI_CLIENT_SSL);
    
            // Check for connection errors
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            Database::$connection = $conn;
        }
    }
    
    
    public static function iud($q){
        Database::setUpConnection();
        Database::$connection->query($q);
    }

    public static function search($q){
        Database::setUpConnection();
        $resultset = Database::$connection->query($q);
        return $resultset;
    }
}

?>