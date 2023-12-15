<?php
session_start();

require '../includes/conn.inc.php';

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
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
}

$ID = isset($_GET['modifierID']) ? $_GET['modifierID'] : null;

// Initialize $userObj
$userObj = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rest of the code remains unchanged

    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $statut = $_POST['Statut'];
    $idteam = $_POST['IDTeam'];
    $idproject = $_POST['IDProject'];
    $role = $_POST['role'];

    $success = $userObj->updateUser($ID, $firstName, $lastName, $email, $phone, $statut, $idteam, $idproject, $role);

    if ($success) {
        header("Location: ./dashboardpo.php");
        exit();
    } else {
        // Handle the error, e.g., display an error message or log the error
        echo "Error updating record!";
    }
}

$select = "SELECT * FROM perssonel WHERE Id = '$ID'";
$result = $conn->query($select);
$row = $result->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="min-h-full">
        <div class="">
            <nav class="bg-gray-800">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="border-b border-gray-700">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-[100px]" src="../img/logo-removebg-preview.png" alt="logo">
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
                                        <!-- liens -->
                                        <a href="./dashboardpo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</a>

                                        <a href="./squadspo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teams</a>

                                        <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</a>

                                        <a href="../logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">logout</a>

                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-4 flex items-center md:ml-6">

                                    <!-- Profile dropdown -->
                                    <div class="ml-3 relative">
                                    </div>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <button type="button" id="burger-menu" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div class="border-b border-gray-700 md:hidden" id="nav-links">
                    <div class="px-2 py-3 space-y-1 sm:px-3">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="./dashboardpo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</a>

                        <a href="./squadspo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teams</a>

                        <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</a>
                    </div>
                </div>
        </div>
        </nav>
    </div>

    <section class="">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Modify account
                    </h1>
                    <form class="max-w-md mx-auto" method="post">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['FirstName']; ?>" name="first_name" id="first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none " placeholder="First name" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['LastName']; ?>" name="last_name" id="last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Last name" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="email" value="<?php echo $row['Email']; ?>" name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Email address" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="tel" value="<?php echo $row['Tel']; ?>" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Phone number (123-456-7890)" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['Statut']; ?>" name="Statut" id="Statut" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Statut" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['IDTeam']; ?>" name="IDTeam" id="IDTeam" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Team ID" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['IDProject']; ?>" name="IDProject" id="IDProject" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Project ID" required />
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <select value="<?php echo $row['role']; ?>" id="role" name="role" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                <option value="user">User</option>
                                <option value="scrum_master">Scrum Master</option>
                                <option value="product_owner">Product Owner</option>
                            </select>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <?php
                            $sql = "SELECT * FROM perssonel";
                            $result1 =  $conn->prepare($sql);

                            // Check if the query was successful
                            if ($result1) {
                                while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                                }
                            } else {
                                // Handle the error, e.g., display an error message or log the error
                            }
                            ?>
                        </div>
                        <button type="submit" name="submit" value="save" class="text-white bg-indigo-700 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-700 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-700 dark:hover:bg-indigo-700 dark:focus:ring-indigo-700">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>






    <script src="./js/script.js"></script>
</body>


</html>