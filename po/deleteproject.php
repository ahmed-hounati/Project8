<?php
require '../includes/conn.inc.php';

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $sql = "DELETE FROM projects WHERE IDProject= '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ./projects.php");
        exit();
    } else {
        die(mysqli_connect_error($conn));
    }
}
