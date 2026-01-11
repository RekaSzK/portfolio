<?php

    session_start();

    if(!isset($_SESSION['userId']))
        {
            header("Location: ../Pages/login.php");
            exit;
        }
?>