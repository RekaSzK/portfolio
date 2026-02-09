<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    $errors = array();

    $successMessage = "";

    //The & makes it so that the function is pass by reference, not by value. This ensures that the $errors array and $successMessage are actually modified not just within the function, but outside of it too.
    function addFile($dbHandler, &$errors, &$successMessage) 
    {
        $fileName = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_SPECIAL_CHARS);
        $fileFormat = filter_input(INPUT_POST, "fileFormat", FILTER_SANITIZE_SPECIAL_CHARS);
        $filePath = filter_input(INPUT_POST, "filePath", FILTER_SANITIZE_SPECIAL_CHARS);
        $fileCategory_id = filter_input(INPUT_POST, "fileCategory_id", FILTER_VALIDATE_INT);
        $fileStatus = filter_input(INPUT_POST, "fileStatus", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($fileName))
        {
            array_push($errors, "Please enter a file name.");
        }
        if(empty($fileFormat))
        {
            array_push($errors, "Please enter a file format.");
        }
        if(empty($filePath))
        {
            array_push($errors, "Please enter a file path.");
        }
        if(empty($fileCategory_id) || $fileCategory_id == FALSE)
        {
            array_push($errors, "Please enter a file category.");
        }
        if(empty($fileStatus))
        {
            array_push($errors, "Please enter a file status.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                INSERT INTO `file` (fileName, fileFormat, filePath, fileCategory_id, fileStatus)
                VALUES (:fileName, :fileFormat, :filePath, :fileCategory_id, :fileStatus)
                ");
                $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
                $stmt->bindParam(":fileFormat", $fileFormat, PDO::PARAM_STR);
                $stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
                $stmt->bindParam(":fileCategory_id", $fileCategory_id, PDO::PARAM_INT);
                $stmt->bindParam(":fileStatus", $fileStatus, PDO::PARAM_STR);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>File added successfully.</p>
                File name: $fileName</br>
                File format: $fileFormat</br>
                File path: $filePath</br>
                File category ID: $fileCategory_id</br>
                File status: $fileStatus</br>";
            }
            catch(Exception $ex)
            {
                die("File could not be added. Error: " . $ex->getMessage());
            }
        }
    }

    function editFile($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid file ID.");
        }

        $fileName = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_SPECIAL_CHARS);
        $fileFormat = filter_input(INPUT_POST, "fileFormat", FILTER_SANITIZE_SPECIAL_CHARS);
        $filePath = filter_input(INPUT_POST, "filePath", FILTER_SANITIZE_SPECIAL_CHARS);
        $fileCategory_id = filter_input(INPUT_POST, "fileCategory_id", FILTER_VALIDATE_INT);
        $fileStatus = filter_input(INPUT_POST, "fileStatus", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($fileName))
        {
            array_push($errors, "Please enter a file name.");
        }
        if(empty($fileFormat))
        {
            array_push($errors, "Please enter a file format.");
        }
        if(empty($filePath))
        {
            array_push($errors, "Please enter a file path.");
        }
        if(empty($fileCategory_id) || $fileCategory_id == FALSE)
        {
            array_push($errors, "Please enter a file category.");
        }
        if(empty($fileStatus))
        {
            array_push($errors, "Please enter a file status.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                UPDATE `file` SET 
                fileName = :fileName, 
                fileFormat = :fileFormat, 
                filePath = :filePath,
                fileCategory_id = :fileCategory_id,
                fileStatus = :fileStatus
                WHERE id = :id
                ");
                $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
                $stmt->bindParam(":fileFormat", $fileFormat, PDO::PARAM_STR);
                $stmt->bindParam(":filePath", $filePath, PDO::PARAM_STR);
                $stmt->bindParam(":fileCategory_id", $fileCategory_id, PDO::PARAM_INT);
                $stmt->bindParam(":fileStatus", $fileStatus, PDO::PARAM_STR);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>File edited successfully.</p>
                File ID: $id</br>
                File name: $fileName</br>
                File format: $fileFormat</br>
                File path: $filePath</br>
                File category ID: $fileCategory_id</br>
                File status: $fileStatus</br>";
            }
            catch(Exception $ex)
            {
                die("File could not be edited. Error: " . $ex->getMessage());
            }
        }
    }

    function deleteFile($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid file ID.");
            return;
        }

        try
        {
            $stmt = $dbHandler->prepare("
            DELETE FROM `file` 
            WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $successMessage = "<p id='noMargin'>File deleted successfully.</p>
            File ID: $id";
        }
        catch(Exception $ex)
        {
            die("File could not be deleted. Error: " . $ex->getMessage());
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_SPECIAL_CHARS);

        if($action == "add")
        {
            addFile($dbHandler, $errors, $successMessage);
        }
        elseif($action == "edit")
        {
            editFile($dbHandler, $errors, $successMessage);
        }
        elseif($action == "delete")
        {
            deleteFile($dbHandler, $errors, $successMessage);
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
    <title>FILE MANAGER</title>
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
                <li><a href='admin_overview.php'>Admin</a></li>
                <li><a href='logout.php'>Log Out</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div id="mainGrid">
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Add File</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="fileName">File name:</label>
                            <input type="text" name="fileName" id="fileName">
                        </p>
                        <p>
                            <label for="fileFormat">File format:</label>
                            <input type="text" name="fileFormat" id="fileFormat">
                        </p>
                        <p>
                            <label for="filePath">File path:</label>
                            <input type="text" name="filePath" id="filePath">
                        </p>
                        <p>
                            <label for="fileCategory_id">File category ID:</label>
                            <input type="text" name="fileCategory_id" id="fileCategory_id">
                        </p>
                        <p>
                            <label for="fileStatus">File status:</label>
                            <input type="text" name="fileStatus" id="fileStatus">
                        </p>
                        <p>
                            <button type="submit" name="action" value="add">Add New File</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Edit File</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">File ID:</label>
                            <input type="text" name="id" id="edit_id">
                        </p>
                        <p>
                            <label for="fileName">File name:</label>
                            <input type="text" name="fileName" id="fileName">
                        </p>
                        <p>
                            <label for="fileFormat">File format:</label>
                            <input type="text" name="fileFormat" id="fileFormat">
                        </p>
                        <p>
                            <label for="filePath">File path:</label>
                            <input type="text" name="filePath" id="filePath">
                        </p>
                        <p>
                            <label for="fileCategory_id">File category ID:</label>
                            <input type="text" name="fileCategory_id" id="fileCategory_id">
                        </p>
                        <p>
                            <label for="fileStatus">File status:</label>
                            <input type="text" name="fileStatus" id="fileStatus">
                        </p>
                        <p>
                            <button type="submit" name="action" value="edit">Edit File</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Delete File</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">File ID:</label>
                            <input type="text" name="id" id="delete_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="delete">Delete File</button>
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