<?php

require_once './includes/conn.inc.php';

class Logout
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        // Redirect to the login page
        header("Location: ./index.php");
        exit();
    }
}

$logoutHandler = new Logout($conn);
$logoutHandler->logout();

?>
