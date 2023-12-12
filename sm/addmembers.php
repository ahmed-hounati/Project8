<?php
session_start();
require '../includes/conn.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teamID'], $_POST['userIDs'])) {
    $teamID = $_POST['teamID'];
    $userIDs = $_POST['userIDs'];

    if (!empty($userIDs)) {
        // Use prepared statement to prevent SQL injection
        $updateQuery = "UPDATE perssonel SET IDTeam = ? WHERE Id IN (" . implode(',', array_fill(0, count($userIDs), '?')) . ")";
        $stmt = mysqli_prepare($conn, $updateQuery);

        // Check if the prepare was successful
        if ($stmt) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, str_repeat('s', count($userIDs) + 1), $teamID, ...$userIDs);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle prepare error
            echo "Error preparing statement: " . mysqli_error($conn);
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add member to team</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


</head>

<body>
    <div class="min-h-full">
        <div class="pb-32">
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
                                        <a href="./dashboardsm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

                                        <a href="./squads.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

                                        <a href="./projectssm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

                                        <a href="../logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">logout</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-4 flex items-center md:ml-6">


                                    <!-- Profile dropdown -->
                                    <div class="ml-3 relative">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="-mr-2 flex md:hidden">
                                <!-- Mobile menu button -->
                                <button type="button" id="burger-menu" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <!--
                    Heroicon name: outline/menu

                    Menu open: "hidden", Menu closed: "block"
                -->
                                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                    <!--
                    Heroicon name: outline/x

                    Menu open: "block", Menu closed: "hidden"
                -->
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
                        <a href="./dashboardsm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

                        <a href="./squads.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

                        <a href="./projectssm.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

                        <a href="./login.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    </div>

                </div>
        </div>
        </nav>
    </div>

    <section class="bg-gray-900">
        <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-24">
            <div class="space-y-12">
                <!-- Add Members Form -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Add Members to Team</h2>

                    <!-- Select Team -->
                    <div class="flex items-center space-x-4">
                        <label class="text-white">Select Team:</label>
                        <select name="teamID" class="bg-gray-800 text-white border border-gray-600 rounded-md p-2">
                            <?php
                            $teamQuery = "SELECT IDEquipe, NomEquipe FROM equipes";
                            $teamResult = mysqli_query($conn, $teamQuery);
                            while ($teamRow = mysqli_fetch_assoc($teamResult)) {
                                echo "<option value='" . $teamRow['IDEquipe'] . "'>" . $teamRow['NomEquipe'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- adduser -->
                    <div class="flex items-center space-x-4">
                        <label class="text-white">Select User(s):</label>
                        <select name="userIDs[]" id="selectUsers" multiple class="bg-gray-800 text-white border border-gray-600 rounded-md p-2">
                            <?php
                            $usersQuery = "SELECT Id, FirstName, LastName FROM perssonel";
                            $usersResult = mysqli_query($conn, $usersQuery);
                            while ($userRow = mysqli_fetch_assoc($usersResult)) {
                                echo "<option value='" . $userRow['Id'] . "'>" . $userRow['FirstName'] . ' ' . $userRow['LastName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Add Members</button>
                </form>
            </div>
        </div>
    </section>

    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#selectUsers').select2({
                placeholder: 'Select users',
                allowClear: true,
                closeOnSelect: false,
            });
        });
    </script>
</body>

</html>