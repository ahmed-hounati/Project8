<?php
require '../includes/conn.inc.php';
require '../classe/po.php';


if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $userObj = new Team($conn);
    $rowCount = $userObj->deleteUser($id);

    if ($rowCount > 0) {
        header("Location: ./dashboardpo.php");
        exit();
    } elseif ($rowCount === 0) {
        // No rows affected, record not found
        header("Location: ./dashboardpo.php?error=recordnotfound");
        exit();
    } else {
        // Error occurred during deletion
        header("Location: ./dashboardpo.php?error=deleteerror");
        exit();
    }
}
