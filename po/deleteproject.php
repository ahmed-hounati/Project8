<?php
require '../includes/conn.inc.php';

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $sql = "DELETE FROM projects WHERE IDProject = :id";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ./projects.php");
            exit();
        } else {
            // No rows affected, record not found
            header("Location: ./projects.php?error=recordnotfound");
            exit();
        }
    } catch (PDOException $e) {
        // Handle PDO errors
        header("Location: ./projects.php?error=" . $e->getMessage());
        exit();
    }
}
