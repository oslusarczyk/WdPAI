<?php

require_once "config.php";

class Database {
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $username = USERNAME;
        $password = PASSWORD;
        $host = HOST;
        $database = DATABASE;

        try {
            $this->connection = new PDO(
                "pgsql:host=$host;port=5432;dbname=$database",
                $username,
                $password,
                ["sslmode"  => "prefer"]
            );
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect()
    {
        return $this->connection;
    }

    public function disconnect()
    {
        $this->connection = null;
    }
}

?>