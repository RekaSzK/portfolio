<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    $errors = array();

    $successMessage = "";

    function addUser($dbHandler, &$errors, &$successMessage) //The & makes it so that the function is pass by reference, not by value. This ensures that the $errors array and $successMessage are actually modified not just within the function, but outside of it too.
    {
        $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_SPECIAL_CHARS);
        $userRole = filter_input(INPUT_POST, "userRole", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

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

                $successMessage = "<p id='noMargin'>User added successfully.</p>
                Username: $userName</br>
                User role: $userRole</br>";
            }
            catch(Exception $ex)
            {
                die("User could not be added. Error: " . $ex->getMessage());
            }
        }
    }

    function editUser($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid user ID.");
        }

        $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_SPECIAL_CHARS);
        $userRole = filter_input(INPUT_POST, "userRole", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

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
                UPDATE `user` SET 
                userName = :userName, 
                userRole = :userRole, 
                password = :password
                WHERE id = :id
                ");
                $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
                $stmt->bindParam(":userRole", $userRole, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashedPass, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>User edited successfully.</p>
                User ID: $id</br>
                Username: $userName</br>
                User role: $userRole</br>";
            }
            catch(Exception $ex)
            {
                die("User could not be edited. Error: " . $ex->getMessage());
            }
        }
    }

    function deleteUser($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid user ID.");
            return;
        }

        try
        {
            $stmt = $dbHandler->prepare("DELETE FROM `user` WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $successMessage = "<p id='noMargin'>User deleted successfully.</p>
            User ID: $id";
        }
        catch(Exception $ex)
        {
            die("User could not be deleted. Error: " . $ex->getMessage());
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_SPECIAL_CHARS);

        if($action == "add")
        {
            addUser($dbHandler, $errors, $successMessage);
        }
        elseif($action == "edit")
        {
            editUser($dbHandler, $errors, $successMessage);
        }
        elseif($action == "delete")
        {
            deleteUser($dbHandler, $errors, $successMessage);
        }
        else
        {
            die("Invalid action.");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER MANAGER</title>
    <link rel="stylesheet" href="../css/manager.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
            </div>
            <ul id="headerList">
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li><a href="presenting.php">Presenting</a></li>
                <li><a href="proskills.php">Professional Skills</a></li>
                <?php
                    if($_SESSION['userRole'] == "admin")
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
        <div id="mainGrid">
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Add User</p>
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
                            <button type="submit" name="action" value="add">Add New User</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Edit User</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">User ID:</label>
                            <input type="text" name="id" id="edit_id">
                        </p>
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
                            <button type="submit" name="action" value="edit">Edit User</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Delete User</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">User ID:</label>
                            <input type="text" name="id" id="delete_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="delete">Delete User</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div id="bottomGrid">
            <div id="backToOverview">
                <a href="users_overview.php">&lt; Back To Overview</a>
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