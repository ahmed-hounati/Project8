<?php
require '../includes/conn.inc.php';

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM perssonel";
        $stmt = $this->conn->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getProjects()
    {
        $sql = "SELECT projects.IDProject, projects.ProjectName, projects.Discription, projects.Datedepart, projects.Datedefini, GROUP_CONCAT(perssonel.FirstName, ' ', perssonel.LastName SEPARATOR ', ') AS Members
                FROM projects 
                JOIN perssonel ON projects.IDProject = perssonel.IDProject
                GROUP BY projects.IDProject";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTeams()
    {
        $sql = "SELECT * FROM equipes";
        $stmt = $this->conn->query($sql);
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $teams;
    }

    public function getTeamMembers($teamId)
    {
        $sql = "SELECT perssonel.FirstName, perssonel.LastName FROM perssonel WHERE IDTeam = :teamId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $members;
    }
}
