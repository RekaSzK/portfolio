<?php

    $dbHandler = null;

    try
    {
        $dbHandler = new PDO('mysql:host=mysql;dbname=portfolio;charset=utf8', "root", "qwerty");
    }
    catch(Exception $ex)
    {
        die("Database could not be reached. Error: " . $ex->getMessage());
    }
?>