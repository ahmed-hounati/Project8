<?php
require '../includes/conn.inc.php';

class Project
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteProject($id)
    {
        $sql = "DELETE FROM projects WHERE IDProject = :id";

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

    $projectObj = new Project($conn);
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
