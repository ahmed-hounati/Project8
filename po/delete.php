<?php
require '../includes/conn.inc.php';

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $sql = "DELETE FROM perssonel WHERE Id = :id";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ./dashboardpo.php");
            exit();
        } else {
            // No rows affected, record not found
            header("Location: ./dashboardpo.php?error=recordnotfound");
            exit();
        }
    } catch (PDOException $e) {
        // Handle PDO errors
        header("Location: ./dashboardpo.php?error=" . $e->getMessage());
        exit();
    }
}
