<?php

    session_start();
    session_unset(); //Clears session variables
    session_destroy(); //Destroys the session

    header("Location: login.php");
    exit;
?>