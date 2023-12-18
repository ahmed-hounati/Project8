<?php

// Check if the class is already defined before declaring it
if (!class_exists('Database')) {

    class Database
    {
        private $host = "localhost";
        private $dbName = "DataWare";
        private $login = "root";
        private $password = "";
        private $conn;

        public function __construct()
        {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->login, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        public function getConnection()
        {
            return $this->conn;
        }
    }
}

// Instantiate the class and get the connection
$db = new Database();
$conn = $db->getConnection();
