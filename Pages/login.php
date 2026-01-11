<?php

    session_start();
    require_once("../dbconnect.php");

    if(isset($_SESSION['userId']))
        {
            header("Location: index.php");
            exit;
        }

    $error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password");

        if(empty($username) || empty($password))
        {
            $error = "Please fill out all fields.";
        }
        else
        {
            //Preparing statement using dbHandler
            $stmt = $dbHandler->prepare("SELECT * FROM `user` WHERE `userName` = ?");
            //Executing statement using $username as userName
            $stmt->execute([$username]);
            //Fetching results
            $user = $stmt->fetch();

            //Password verification
            if($user && password_verify($password, $user['password']))
            {
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['userRole'] = $user['userRole'];

                header("Location: index.php");
                exit;
            }
            else
            {
                $error = "Invalid username or password.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG IN</title>
</head>
<body>
    <?php
        if (!empty($error))
        {
            echo "<p id='errorOutput'>" . $error . "</p>";
        }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Log In</button>
    </form>
</body>
</html>