<?php

class Team
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
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

    public function deleteProject($id)
    {
        $sql = "DELETE FROM projects WHERE IDProject = :id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return -1;
        }
    }

    public function addProject($ProjectName, $Discription, $Datedefini, $IDPO)
    {
        $sql = "INSERT INTO projects (ProjectName, Discription, Datedepart, Datedefini, IDPO) VALUES (:ProjectName, :Discription, NOW(), :Datedefini, :IDPO)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':ProjectName', $ProjectName);
            $stmt->bindParam(':Discription', $Discription);
            $stmt->bindParam(':Datedefini', $Datedefini);
            $stmt->bindParam(':IDPO', $IDPO);

            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getUserByID($id)
    {
        $select = "SELECT * FROM perssonel WHERE Id = :ID";
        $result = $this->conn->prepare($select);
        $result->bindParam(':ID', $id);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $firstName, $lastName, $email, $phone, $statut, $idteam, $idproject, $role)
    {
        $sql = "UPDATE perssonel SET FirstName=:firstName, LastName=:lastName, Email=:email, Tel=:phone, Statut=:Statut, IDTeam=:IDTeam, IDProject=:IDProject, role=:role WHERE Id = :ID";


        try {
            $updateResult = $this->conn->prepare($sql);
            $updateResult->bindParam(':firstName', $firstName);
            $updateResult->bindParam(':lastName', $lastName);
            $updateResult->bindParam(':email', $email);
            $updateResult->bindParam(':phone', $phone);
            $updateResult->bindParam(':Statut', $statut);
            $updateResult->bindParam(':IDTeam', $idteam);
            $updateResult->bindParam(':IDProject', $idproject);
            $updateResult->bindParam(':role', $role);
            $updateResult->bindParam(':ID', $id);

            return $updateResult->execute();
        } catch (PDOException $e) {
            // Handle PDO errors
            echo "Error updating record: " . $e->getMessage();
            return false;
        }
    }

    public function getProjectByID($id)
    {
        $select = "SELECT * FROM projects WHERE IDProject = :ID";
        $result = $this->conn->prepare($select);
        $result->bindParam(':ID', $id);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProject($id, $projectName, $description, $datedefini)
    {
        $sql = "UPDATE projects SET ProjectName=?, Discription=?, Datedefini=? WHERE IDProject = ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $projectName);
            $stmt->bindParam(2, $description);
            $stmt->bindParam(3, $datedefini);
            $stmt->bindParam(4, $id);

            $result = $stmt->execute();

            if ($result) {
                return true;
            } else {
                echo "Error updating project: " . $stmt->errorInfo()[2];
                return false;
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        } finally {
            $stmt = null;
        }
    }
}
