<?php

    $dbHandler = null;

    try
    {
        $dbHandler = new PDO('mysql:host=mysql;dbname=portfolio;charset=utf8', "root", "qwerty");
    }
    catch(Exception $ex)
    {
        echo $ex;
    }
?>