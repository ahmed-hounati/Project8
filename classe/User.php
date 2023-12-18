<?php

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

    public function idpo()
    {
        $sql = "SELECT projects.IDPO, perssonel.FirstName, perssonel.LastName
        FROM projects 
        JOIN perssonel ON projects.IDPO = perssonel.Id;";
        $stmt = $this->conn->query($sql);
        $po = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function addPersonnel($firstName, $lastName, $email, $phone, $idTeam, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $status = 'active';

        $sql = "INSERT INTO perssonel (FirstName, LastName, Email, Tel, IDTeam, Passdwd, Statut) 
                VALUES (:firstName, :lastName, :email, :phone, :idTeam, :password, :status)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':idTeam', $idTeam);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':status', $status);

            $result = $stmt->execute();

            if ($result) {
                header("Location: ./index.php");
                exit();
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM perssonel WHERE Email=:email;";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $passwordCheck = password_verify($password, $row['Passdwd']);
                if ($passwordCheck === false) {
                    return 'wrongpassword';
                } elseif ($passwordCheck === true) {
                    $_SESSION['Email'] = $row['Email'];

                    if (isset($row['role'])) {
                        $_SESSION['role'] = $row['role'];
                    }

                    switch ($_SESSION['role']) {
                        case 'user':
                            return 'user/dashboarduser.php';
                        case 'product_owner':
                            return 'po/dashboardpo.php';
                        case 'scrum_master':
                            return 'sm/dashboardsm.php';
                    }
                }
            } else {
                return 'nonuser';
            }
        } catch (PDOException $e) {
            return 'sqlerror';
        }
    }
}
