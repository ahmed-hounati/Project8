<?php

session_start();

require './includes/conn.inc.php';

class UserAuthentication
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
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['Email'];
    $password = $_POST['Passdwd'];

    if (empty($email) || empty($password)) {
        header("Location: index.php?error=emptyfields");
        exit();
    } else {
        $db = new Database();
        $conn = $db->getConnection();

        $userAuthentication = new UserAuthentication($conn);
        $userAuthentication->loginUser($email, $password);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="min-h-full">
        <div class="pb-24">
            <nav class="bg-gray-800">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="border-b border-gray-700">
                        <div class="flex items-center justify-between h-16 px-4 sm:px-0">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="w-[100px]" src="./img/logo-removebg-preview.png" alt="logo">
                                </div>
                                <div class="hidden md:block">
                                    <div class="ml-10 flex items-baseline space-x-4">
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
                    </div>

            </nav>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                    <div class="max-w-md w-full space-y-8">
                        <div>
                            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Login to your account</h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                            </p>
                        </div>
                        <form class="mt-8 space-y-6" action="index.php" method="POST">
                            <input type="hidden" name="remember" value="true">
                            <div class="rounded-md shadow-sm -space-y-px">
                                <div class="p-2">
                                    <label for="email-address" class="sr-only">Email address</label>
                                    <input id="Email" name="Email" type="email" autocomplete="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                                </div>
                                <div class="p-2">
                                    <label for="password" class="sr-only">Password</label>
                                    <input id="Passdwd" name="Passdwd" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                                </div>

                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                </div>
                                <a href="./signup.php" class="text-indigo-600">Sign Up?</a>
                            </div>

                            <div>
                                <button type="submit" name="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">

                                        </svg>
                                    </span>
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>





    <script src="./js/script.js"></script>
</body>

</html>