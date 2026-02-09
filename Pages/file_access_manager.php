<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    $errors = array();

    $successMessage = "";

    function addFileAccess($dbHandler, &$errors, &$successMessage) //The & makes it so that the function is pass by reference, not by value. This ensures that the $errors array and $successMessage are actually modified not just within the function, but outside of it too.
    {
        $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
        $file_id = filter_input(INPUT_POST, "file_id", FILTER_VALIDATE_INT);

        if(empty($user_id) || $user_id == FALSE)
        {
            array_push($errors, "Please enter a user ID.");
        }
        if(empty($file_id) || $file_id == FALSE)
        {
            array_push($errors, "Please enter a file ID.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                INSERT INTO `file_access` (user_id, file_id)
                VALUES (:user_id, :file_id)
                ");
                $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                $stmt->bindParam(":file_id", $file_id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>File access added successfully.</p>
                User ID: $user_id</br>
                File ID: $file_id</br>";
            }
            catch(Exception $ex)
            {
                die("File access could not be added. Error: " . $ex->getMessage());
            }
        }
    }

    function editFileAccess($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if(empty($id) || $id == FALSE)
        {
            array_push($errors, "Please enter an ID.");
        }

        $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);
        $file_id = filter_input(INPUT_POST, "file_id", FILTER_VALIDATE_INT);

        if(empty($user_id) || $user_id == FALSE)
        {
            array_push($errors, "Please enter a user ID.");
        }
        if(empty($file_id) || $file_id == FALSE)
        {
            array_push($errors, "Please enter a file ID.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                UPDATE `file_access` SET 
                user_id = :user_id, 
                file_id = :file_id,
                WHERE id = :id
                ");
                $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                $stmt->bindParam(":file_id", $file_id, PDO::PARAM_INT);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>File access edited successfully.</p>
                ID: $id</br>
                User ID: $user_id</br>
                File ID: $file_id</br>";
            }
            catch(Exception $ex)
            {
                die("File access could not be edited. Error: " . $ex->getMessage());
            }
        }
    }

    function deleteFileAccess($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid ID.");
            return;
        }

        try
        {
            $stmt = $dbHandler->prepare("DELETE FROM `file_access` WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $successMessage = "<p id='noMargin'>File access deleted successfully.</p>
            ID: $id";
        }
        catch(Exception $ex)
        {
            die("File access could not be deleted. Error: " . $ex->getMessage());
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_SPECIAL_CHARS);

        if($action == "add")
        {
            addFileAccess($dbHandler, $errors, $successMessage);
        }
        elseif($action == "edit")
        {
            editFileAccess($dbHandler, $errors, $successMessage);
        }
        elseif($action == "delete")
        {
            deleteFileAccess($dbHandler, $errors, $successMessage);
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
    <title>FILE ACCESS MANAGER</title>
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
        <div id="mainGrid">
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Add File Access</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="user_id">User ID:</label>
                            <input type="text" name="user_id" id="user_id">
                        </p>
                        <p>
                            <label for="file_id">File ID:</label>
                            <input type="text" name="file_id" id="file_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="add">Add New File Access</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Edit File Access</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">ID:</label>
                            <input type="text" name="id" id="id">
                        </p>
                        <p>
                            <label for="user_id">User ID:</label>
                            <input type="text" name="user_id" id="user_id">
                        </p>
                        <p>
                            <label for="file_id">File ID:</label>
                            <input type="text" name="file_id" id="file_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="edit">Edit File Access</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Delete File Access</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="user_id">User ID:</label>
                            <input type="text" name="user_id" id="user_id">
                        </p>
                        <p>
                            <label for="file_id">File ID:</label>
                            <input type="text" name="file_id" id="file_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="delete">Delete File Access</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div id="bottomGrid">
            <div id="backToOverview">
                <a href="files_overview.php">&lt; Back To Overview</a>
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