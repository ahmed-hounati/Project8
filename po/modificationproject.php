<?php
session_start();

require '../includes/conn.inc.php';

$ID = $_GET['modifierID'];


$row = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ProjectName = $_POST['ProjectName'];
    $description = $_POST['Discription'];
    $datedefini = $_POST['Datedefini'];


    $sql = "UPDATE projects SET ProjectName='$ProjectName', Discription='$description', Datedefini='$datedefini' WHERE IDProject = '$ID'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: ./projects.php");
        exit();
    } else {
        die(mysqli_error($conn));
    }
}

$select = "SELECT * FROM projects WHERE IDProject = '$ID'";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_array($result);


mysqli_free_result($result);
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
                                        <a href="./dashboard.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</a>

                                        <a href="./squads.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Teams</a>

                                        <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</a>

                                        <a href="../logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">logout</a>

                                        <a href="./signup.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign Up</a>
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
                        <a href="./dashboard.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

                        <a href="./squads.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

                        <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

                        <a href="./login.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Login</a>

                        <a href="./signup.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Sign Up</a>
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
                        Modify Team
                    </h1>
                    <form class="max-w-md mx-auto" method="post">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['ProjectName']; ?>" name="ProjectName" id="ProjectName" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none " placeholder="ProjectName" required />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['Discription']; ?>" name="Discription" id="Discription" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Description" required />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['Datedefini']; ?>" name="Datedefini" id="Datedefini" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="Final Date : yyyy-mm-dd" required />
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" value="<?php echo $row['IDPO']; ?>" name="IDPO" id="IDPO" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-lime-500 focus:outline-none" placeholder="ID product owner" required />
                        </div>


                        <div class="relative z-0 w-full mb-5 group">
                            <?php
                            $sql = "SELECT * FROM projects";
                            $result1 = mysqli_query($conn, $sql);

                            // Check if the query was successful
                            if ($result1) {
                                while ($row = mysqli_fetch_assoc($result1)) {
                                }
                                // Free result set
                                mysqli_free_result($result1);
                            } else {
                                // Handle the error, e.g., display an error message or log the error
                                echo "Error: " . mysqli_connect_error($conn);
                            }
                            ?>
                        </div>
                        <button type="submit" name="submit" value="save" class="text-white bg-indigo-700 hover:bg-lime-800 focus:ring-4 focus:outline-none focus:ring-indigo-700 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-700 dark:hover:bg-indigo-700 dark:focus:ring-indigo-700">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>






    <script src="./js/script.js"></script>
</body>


</html>