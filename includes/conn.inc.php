<?php
$serverName = "localhost";
$DBName = "DataWare";
$login = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$DBName", $login, $password);

    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
