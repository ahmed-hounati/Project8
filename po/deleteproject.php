<?php
require '../includes/conn.inc.php';
require '../classe/po.php';


if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $projectObj = new Team($conn);
    $rowCount = $projectObj->deleteProject($id);

    if ($rowCount > 0) {
        header("Location: ./projects.php");
        exit();
    } elseif ($rowCount === 0) {
        // No rows affected, record not found
        header("Location: ./projects.php?error=recordnotfound");
        exit();
    } else {
        // Error occurred during deletion
        header("Location: ./projects.php?error=deleteerror");
        exit();
    }
}
