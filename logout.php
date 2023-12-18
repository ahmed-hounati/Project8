<?php
require './includes/conn.inc.php';
require './classe/auth.php';

$logoutHandler = new Auth($conn);
$logoutHandler->logout();
