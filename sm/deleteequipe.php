<?php
require '../includes/conn.inc.php';

class TeamManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function deleteTeam($id)
    {
        $sql = "DELETE FROM equipes WHERE IDEquipe = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

$teamManager = new TeamManager($conn);

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $result = $teamManager->deleteTeam($id);

    if ($result === true) {
        header("Location: ./squads.php");
        exit();
    } else {
        echo $result;
    }
}
