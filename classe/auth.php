<?php

class Auth
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($email, $password)
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
                    header("Location: index.php?error=wrongpassword");
                    exit();
                } elseif ($passwordCheck === true) {
                    $_SESSION['Email'] = $row['Email'];

                    if (isset($row['role'])) {
                        $_SESSION['role'] = $row['role'];

                        switch ($_SESSION['role']) {
                            case 'user':
                                header("Location: user/dashboarduser.php");
                                exit();
                            case 'product_owner':
                                header("Location: po/dashboardpo.php");
                                exit();
                            case 'scrum_master':
                                header("Location: sm/dashboardsm.php");
                                exit();
                            default:
                                // Handle unknown role (redirect to a default page or show an error)
                                header("Location: index.php?error=unknownrole");
                                exit();
                        }
                    }
                }
            } else {
                header("Location: index.php?error=nonuser");
                exit();
            }
        } catch (PDOException $e) {
            header("Location: login.php?error=sqlerror");
            exit();
        }
    }

    public function registerUser($firstName, $lastName, $email, $phone, $idTeam, $password)
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

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();

        // Redirect to the login page
        header("Location: ./index.php");
        exit();
    }
}
