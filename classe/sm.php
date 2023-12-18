<?php

class Project
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
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

    public function updateTeam($id, $equipeName, $statut)
    {
        $sql = "UPDATE equipes SET NomEquipe=:equipeName, Statut=:statut WHERE IDEquipe = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':equipeName', $equipeName, PDO::PARAM_STR);
            $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
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


    public function addTeam($nomEquipe, $statut)
    {
        $sql = "INSERT INTO equipes (NomEquipe, Statut, DateCreation) VALUES (?, ?, NOW())";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $nomEquipe, PDO::PARAM_STR);
            $stmt->bindParam(2, $statut, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
