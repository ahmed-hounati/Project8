<?php
require '../includes/conn.inc.php';

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $sql = "DELETE FROM perssonel WHERE Id= '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ./dashboardpo.php");
        exit();
    } else {
        die(mysqli_connect_error($conn));
    }
}
