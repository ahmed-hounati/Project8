<?php
require '../includes/conn.inc.php';
require '../classe/sm.php';


$teamManager = new Project($conn);

if (isset($_GET['DeleteID'])) {
    $id = $_GET['DeleteID'];

    $result = $teamManager->deleteTeam($id);

    if ($result === true) {
        header("Location: ./squads.php");
        exit();
    } else {
        echo $result;
    }
}
