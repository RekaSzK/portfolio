<?php
    require_once("../dbconnect.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $errors = validateRegister(); //to store the return of validateRegister() (= the errors) in $errors
    }

    function validateRegister()
    {
        global $dbHandler; //$dbHandler does not exist within function scope, so global $dbHandler; is needed

        $userName = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_SPECIAL_CHARS);
        $userRole = filter_input(INPUT_POST, "userRole");
        $password = filter_input(INPUT_POST, "password");
        
        $errors = array();

        if(empty($userName))
        {
            array_push($errors, "Please enter a username.");
        }
        if(empty($userRole))
        {
            array_push($errors, "Please select a user role.");
        }
        if(empty($password))
        {
            array_push($errors, "Please enter a password.");
        }

        if(empty($errors))
        {
            $userNameInUse = "";

            $stmt = $dbHandler->prepare("
            SELECT * 
            FROM `user` 
            WHERE userName = :userName");
            $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
            $stmt->execute();

            $userNameInUse = $stmt->fetch(PDO::FETCH_ASSOC);

            if(empty($userNameInUse))
            {
                $hashedPass = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $dbHandler->prepare("
                SELECT id 
                FROM `role` 
                WHERE roleName = :userRole");
                $stmt->bindParam(":userRole", $userRole, PDO::PARAM_STR);
                $stmt->execute();
                $userRoleId = $stmt->fetch(PDO::FETCH_ASSOC);

                try
                {
                    $stmt = $dbHandler->prepare("
                    INSERT INTO `user` (userName, password, role_id) 
                    VALUES (:userName, :hashedPass, :userRoleId)");
                    $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
                    $stmt->bindParam(":hashedPass", $hashedPass, PDO::PARAM_STR);
                    $stmt->bindParam(":userRoleId", $userRoleId['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    header("Location: login.php");
                    exit;
                }
                catch(Exception $ex)
                {
                    array_push($errors, "Could not register. Error: " . $ex->getMessage());
                }
            }
            else
            {
                array_push($errors, "Username already in use.");
            }
        }
        
        return($errors);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            REGISTER
        </div>
    </header>
    <main>
        <div id="mainField">
            <div id="mainContainer">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="formCategory">
                        <label for="userName">Username:</label>
                        <input type="text" name="userName" id="userName">
                    </div>
                    <div class="formCategory">
                        <label for="userRole">Choose User Role:</label>
                        <select id="userRole" name="userRole">
                            <option value="" selected disabled>Select an option</option>
                            <option value="visitor">Visitor</option>
                            <option value="lecturer">Lecturer</option>
                            <option value="student">Student</option>
                            <option value="studyCareerCoach">Study Career Coach</option>
                        </select>
                    </div>
                    <div class="formCategory">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div id="buttonContainer">
                        <button id="registerButton" type="submit">Register</button>
                    </div>
                </form>
                <div id="errorsContainer">
                    <?php
                        if(!empty($errors))
                        {
                            foreach($errors as $error)
                            {
                                echo "<p id='errorOutput'>" . htmlspecialchars($error) . "</p>";
                            }
                        }        
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>