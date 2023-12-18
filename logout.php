<?php

require_once './includes/conn.inc.php';

session_start();
$_SESSION = array();
session_destroy();

// Redirect to the login page
header("Location: ./index.php");
exit();
