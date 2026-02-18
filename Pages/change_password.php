<?php
    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");
    
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];

    $errors = array();

    $successMessage = "";

    function validateInput($userId, $dbHandler, &$errors, &$successMessage)
    {
        $newPassword = filter_input(INPUT_POST, "newPassword");

        if(empty($newPassword))
        {
            array_push($errors, "Please enter a new password.");
        }
        else
        {
            try
            {
                $stmt = $dbHandler->prepare("
                SELECT * 
                FROM `user` 
                WHERE id = :id");
                $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
                $stmt->execute();

                $user = $stmt->fetch();
            }
            catch(Exception $ex)
            {
                die("Error when retrieving user data. Error: " . $ex->getMessage());
            }

            if($user && password_verify($newPassword, $user['password']))
            {
                array_push($errors, "Password cannot be the same as old password.");
            }
            elseif($user && !password_verify($newPassword, $user['password']))
            {
                $newHashedPass = password_hash($newPassword, PASSWORD_DEFAULT);

                try
                {
                    $stmt = $dbHandler->prepare("
                    UPDATE `user` 
                    SET password = :password 
                    WHERE id = :id");
                    $stmt->bindParam(":password", $newHashedPass, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
                    $stmt->execute();

                    if($stmt->rowCount() == 1)
                    {
                    $successMessage = "<p id='noMargin'>Password modified successfully.</p>";
                    }
                    else
                    {
                        array_push($errors, "Password change failed.");
                    }

                }
                catch(Exception $ex)
                {
                    die("Password could not be updated. Error: " . $ex->getMessage());
                }
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        validateInput($userId, $dbHandler, $errors, $successMessage);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/change_password.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
                <a id ="pfp" href="profile.php">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>
            </div>
            <ul id="headerList">
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li><a href="presenting.php">Presenting</a></li>
                <li><a href="proskills.php">Professional Skills</a></li>
                <li><a href="projects.php">Projects</a></li>
                <?php
                    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin")
                    {
                        echo "<li><a href='admin_overview.php'>Admin</a></li>";
                    }
                ?>
                <?php
                    if(isset($_SESSION['userId']))
                    {
                        echo "<li><a href='logout.php'>Log Out</a></li>";
                    }
                ?>
            </ul>
        </div>
    </header>
    <main>
        <div id ="outerField">
            <div id="mainField">
                <div id="mainContainer">
                    <p id="title">Change Password</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <label for="newPassword">New Password: </label>
                        <input type="password" name="newPassword" id="newPassword">
                        <button type="submit" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="bottomGrid">
            <div id="backToProfile">
                <a href="profile.php">&lt; Back To Profile</a>
            </div>

            <?php if(!empty($errors)): ?>
                <div id="errors">
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            
            <?php elseif(!empty($successMessage)): ?>
                <div id="success">
                    <p><?php echo $successMessage; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>