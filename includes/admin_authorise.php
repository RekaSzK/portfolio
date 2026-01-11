<?php

    session_start();

    //If user is not logged in (first two cases) or they're logged in but not as an admin (last case)
    if(!isset($_SESSION['userId']) || !isset($_SESSION['userRole']) || $_SESSION['userRole'] !== 'admin')
        {
            header("Location: ../Pages/index.php");
            exit;
        }
?>