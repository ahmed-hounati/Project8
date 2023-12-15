<?php
session_start();
require '../includes/conn.inc.php';

class TeamDashboard
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
}

$teamDashboard = new TeamDashboard($conn);
$teams = $teamDashboard->getTeams();

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
                                    <a href="./dashboardpo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

                                    <a href="./squadspo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

                                    <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

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
                    <a href="./dashboardpo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>

                    <a href="./squadspo.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

                    <a href="./projects.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

                    <a href="../logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Logout</a>
                </div>

            </div>
    </div>
    </nav>
    <section class="bg-gray-900">
        <div class="mx-auto py-12 px-4 max-w-7xl sm:px-6 lg:px-8 lg:py-24">
            <div class="space-y-12">
                <div class="space-y-5 flex justify-around sm:space-y-4 md:max-w-xl lg:max-w-3xl xl:max-w-none">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">Teams Lists</h2>
                </div>
                <ul role="list" class="space-y-4 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0 lg:grid-cols-3 lg:gap-8">
                    <?php foreach ($teams as $team) : ?>
                        <li class="py-10 px-6 bg-gray-800 text-center rounded-lg xl:px-10 xl:text-left">
                            <div class="space-y-6 xl:space-y-10">
                                <div class="space-y-2 xl:flex xl:items-center xl:justify-between">
                                    <div class="font-medium text-lg leading-6 space-y-1">
                                        <h3 class="text-white"> Team name: <?php echo $team['NomEquipe']; ?></h3>
                                        <p class="text-white"> Statut: <?php echo $team['Statut']; ?></p>
                                        <h2 class="text-white">Members : </h2>
                                        <?php $members = $teamDashboard->getTeamMembers($team['IDEquipe']); ?>
                                        <?php foreach ($members as $member) : ?>
                                            <h3 class="text-white"><?php echo $member['FirstName']; ?> - <?php echo $member['LastName']; ?></h3>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </section>
    </div>

    <script src="./js/script.js"></script>
</body>

</html>