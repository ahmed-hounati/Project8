<?php
require '../includes/conn.inc.php';

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $sql = "DELETE FROM equipes WHERE IDEquipe= :id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ./squads.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
