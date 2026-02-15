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
            
            $stmt = $dbHandler->prepare("
            SELECT user.id, user.userName, user.password, role.roleName 
            FROM `user` INNER JOIN `role` ON user.role_id = role.id 
            WHERE user.userName = :userName");
            $stmt->bindParam(":userName", $username, PDO::PARAM_STR);
            $stmt->execute();
            
            $user = $stmt->fetch();

            //Password verification
            if($user && password_verify($password, $user['password']))
            {
                $_SESSION['userId'] = $user['id'];
                $_SESSION['userName'] = $user['userName'];
                $_SESSION['role'] = $user['roleName'];

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
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            LOG IN
        </div>
    </header>
    <main>
        <div id="mainField">
            <div id="mainContainer">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="formCategory">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" autocomplete="username">
                    </div>
                    <div class="formCategory">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" autocomplete="current-password">
                    </div>
                    <div id="buttonContainer">
                        <button id="loginButton" type="submit">Log In</button>
                        <a href="register.php">Register</a>
                    </div>
                </form>
                <div id="errorsContainer">
                    <?php
                        if(!empty($error))
                        {
                            echo "<p id='errorOutput'>" . $error . "</p>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>