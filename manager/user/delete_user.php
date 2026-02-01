<?php
    require("../../includes/admin_authorise.php");
    require("../../dbconnect.php");

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    try
    {
        $stmt = $dbHandler->prepare("DELETE FROM `user` WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../../Pages/users_overview.php");
        exit;
    }
    catch(Exception $ex)
    {
        die("User could not be deleted. Error: " . $ex->getMessage());
    }
?>