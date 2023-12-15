<?php

require_once './includes/conn.inc.php';

class LogoutHandler
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function logout()
    {
        // Destroy the session
        session_start();
        $_SESSION = array();
        session_destroy();

        // Redirect to the login page
        header("Location: ./index.php");
        exit();
    }
}

// Usage
$logoutHandler = new LogoutHandler($conn);
$logoutHandler->logout();
