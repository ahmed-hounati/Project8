<?php
$serverName = "localhost";
$DBName = "DataWare";
$login = "root";
$password = "";
$conn = mysqli_connect($serverName, $login, $password, $DBName);

if (!$conn) {
    die("Connection failed : " . mysqli_connect_error());
}
