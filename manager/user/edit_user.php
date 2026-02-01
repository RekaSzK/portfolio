<?php
    require("../../includes/admin_authorise.php");
    require("../../dbconnect.php");

    $errors = array();

    //We try and get id from GET
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    //If id from GET is null or false, we try POST
    if($id === NULL || $id === FALSE)
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    }

    //If id in POST is still null or false, we cannot retrieve id
    if ($id === null || $id === false)
    {
        die("User ID could not be retrieved.");
    }

    $stmt = $dbHandler->prepare("SELECT * FROM `user` WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user)
    {
        die("User could not be found.");
    }

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
                UPDATE `user` SET 
                userName = :userName, 
                userRole = :userRole, 
                password = :password
                WHERE id = :id");
                $stmt->bindParam(":userName", $userName, PDO::PARAM_STR);
                $stmt->bindParam(":userRole", $userRole, PDO::PARAM_STR);
                $stmt->bindParam(":password", $hashedPass, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                header("Location: ../../Pages/users_overview.php");
                exit;
            }
            catch(Exception $ex)
            {
                die("User could not be edited. Error: " . $ex->getMessage());
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT USER</title>
</head>
<body>
    <h1>Edit User</h1>

    <?php if(!empty($errors)): ?>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label for="userName">Username:</label>
            <input type="text" name="userName" id="userName" value="<?php echo htmlspecialchars($user['userName']); ?>">
        </p>
        <p>
            <label for="userRole">User role:</label>
            <input type="text" name="userRole" id="userRole" value="<?php echo htmlspecialchars($user['userRole']); ?>">
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>">
        </p>
        <p>
            <button type="submit" name="user" value="edit">Submit User</button>
        </p>
    </form>
</body>
</html>