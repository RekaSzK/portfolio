<?php
    require("../../includes/admin_authorise.php");
    require("../../dbconnect.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_SPECIAL_CHARS);
        $userRole = filter_input(INPUT_POST, "userRole", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $errors = array();

        if(empty($userName))
        {
            array_push($errors, "Please enter a username.");
        }
        if(empty($userRole))
        {
            array_push($errors, "Please enter a user role.");
        }
        if(empty($password) || strlen($password) < 8)
        {
            array_push($errors, "Please enter a valid password.");
        }

        if(empty($errors))
        {
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);

            try
            {
                $stmt = $dbHandler->prepare("
                INSERT INTO `user` (userName, userRole, password)
                VALUES (:userName, :userRole, :password)
                ");
                $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
                $stmt->bindParam(":userRole", $userRole, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashedPass, PDO::PARAM_STR);
                $stmt->execute();

                header("Location: ../../Pages/users_overview.php");
                exit;
            }
            catch(Exception $ex)
            {
                die("User could not be added. Error: " . $ex->getMessage());
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD USER</title>
</head>
<body>
    <h1>Add User</h1>

    <?php if(!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?><li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <p>
            <label for="userName">Username:</label>
            <input type="text" name="userName" id="userName">
        </p>
        <p>
            <label for="userRole">User role:</label>
            <input type="text" name="userRole" id="userRole">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password">
        </p>
        <p>
            <button type="submit">Add New User</button>
        </p>
    </form>
    <a href="../../Pages/users_overview.php">Back To Users</a>
</body>
</html>