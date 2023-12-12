<?php
session_start();
require '../includes/conn.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <div class="space-y-5 flex justify-around sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Teams Lists</h2>
                    <a href="addmembers.php" class="text-indigo-500 text-xl font-extrabold tracking-tight sm:text-xl">Add users to teams</a>
                    <a href="addsquiad.php" class="text-indigo-500 text-xl font-extrabold tracking-tight sm:text-xl">Add Team</a>
                </div>
                <ul role="list" class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 lg:gap-8">
                    <?php
                    $sql = "SELECT * FROM equipes";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <li class="py-10 px-6 bg-gray-800 text-center rounded-lg xl:px-10 xl:text-left">
                            <div class="space-y-6 xl:space-y-10">
                                <div class="space-y-2 xl:flex xl:items-center xl:justify-between">
                                    <div class="font-medium text-lg leading-6 space-y-1">
                                        <h3 class="text-indigo-700">Team ID:
                                            <?php
                                            echo $row['IDEquipe'];
                                            ?>
                                        </h3>
                                        <h3 class="text-indigo-700"> Team name:
                                            <?php
                                            echo $row['NomEquipe'];
                                            ?>
                                        </h3>
                                        <p class="text-white"> Statut:
                                            <?php
                                            echo $row['Statut'];
                                            ?>
                                        </p>
                                        <p class="text-white"> Creation Date:
                                            <?php
                                            echo $row['DateCreation'];
                                            ?>
                                        </p>

                                    </div>

                                    <ul role="list" class="flex justify-center space-x-5">
                                        <li>
                                            <a href="modificationequipe.php?modifierID=<?php echo $row['IDEquipe'] ?>" class="text-indigo-700 hover:text-indigo-700">
                                                <svg class="w-8 h-6" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512">
                                                    <style>
                                                        svg {
                                                            fill: #84cc16
                                                        }
                                                    </style>
                                                    <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H322.8c-3.1-8.8-3.7-18.4-1.4-27.8l15-60.1c2.8-11.3 8.6-21.5 16.8-29.7l40.3-40.3c-32.1-31-75.7-50.1-123.9-50.1H178.3zm435.5-68.3c-15.6-15.6-40.9-15.6-56.6 0l-29.4 29.4 71 71 29.4-29.4c15.6-15.6 15.6-40.9 0-56.6l-14.4-14.4zM375.9 417c-4.1 4.1-7 9.2-8.4 14.9l-15 60.1c-1.4 5.5 .2 11.2 4.2 15.2s9.7 5.6 15.2 4.2l60.1-15c5.6-1.4 10.8-4.3 14.9-8.4L576.1 358.7l-71-71L375.9 417z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="deleteequipe.php?DeleteID=<?php echo $row['IDEquipe'] ?>" class="text-indigo-700 hover:text-indigo-700">
                                                <svg class="w-6 h-6 mt-3" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                                    <style>
                                                        svg {
                                                            fill: #84cc16
                                                        }
                                                    </style>
                                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php
                    }

                    mysqli_free_result($result);
                    ?>
                </ul>
            </div>
        </div>
    </section>
    </div>




    <script src="./js/script.js"></script>
</body>

</html>