<?php
require '../includes/conn.inc.php';

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM perssonel WHERE Id = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Handle PDO errors
            echo "Error: " . $e->getMessage();
            return -1;
        }
    }
}

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $userObj = new User($conn);
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
