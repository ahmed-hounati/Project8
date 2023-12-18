<?php

$host = "localhost";
$dbName = "DataWare";
$login = "root";
$password = "";

try {
    $conn = new PDO("mysql:host={$host};dbname={$dbName}", $login, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}