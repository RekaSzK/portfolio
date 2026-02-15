<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    $errors = array();

    $successMessage = "";

    $acceptedFileTypesExtensions = [
        "application/pdf" => "pdf", "application/vnd.openxmlformats-officedocument.presentationml.presentation" => "pptx", 
        "application/msword" => "doc", "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "docx"];

    //The & makes it so that the function is pass by reference, not by value. This ensures that the $errors array and $successMessage are actually modified not just within the function, but outside of it too.
    function addFile($dbHandler, &$errors, &$successMessage, $acceptedFileTypesExtensions) 
    {
        $fileName = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_SPECIAL_CHARS);
        $chosenDirectory = filter_input(INPUT_POST, "chosenDirectory");
        $fileCategory_id = filter_input(INPUT_POST, "fileCategory_id", FILTER_VALIDATE_INT);
        $fileStatus = filter_input(INPUT_POST, "fileStatus", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($fileName))
        {
            array_push($errors, "Please enter a file name.");
        }
        if(empty($chosenDirectory))
        {
            array_push($errors, "Please choose directory.");
        }
        if(empty($fileCategory_id) || $fileCategory_id == FALSE)
        {
            array_push($errors, "Please enter a file category.");
        }
        if(empty($fileStatus))
        {
            array_push($errors, "Please enter a file status.");
        }
        if(!isset($_FILES['uploadedFile']) || $_FILES['uploadedFile']['error'] !== 0)
        {
            array_push($errors, "Error when uploading file.");
        }

        if(empty($errors))
        {
            $fileMime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['uploadedFile']['tmp_name']);

            if(array_key_exists($fileMime, $acceptedFileTypesExtensions))
            {
                $fileFormat = $acceptedFileTypesExtensions[$fileMime];
                $fullFileName = $fileName . "." . $fileFormat;
                
                if(!file_exists("../files/" . $chosenDirectory . "/" . $fullFileName))
                {
                    $filePath = "../files/" . $chosenDirectory . "/" . $fullFileName;

                    if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $filePath))
                    {
                        try
                        {
                            $newFilePath = "files/" . $chosenDirectory . "/" . $fullFileName;
                            $stmt = $dbHandler->prepare("
                            INSERT INTO `file` (fileName, fileFormat, filePath, fileCategory_id, fileStatus)
                            VALUES (:fileName, :fileFormat, :newFilePath, :fileCategory_id, :fileStatus)
                            ");
                            $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
                            $stmt->bindParam(":fileFormat", $fileFormat, PDO::PARAM_STR);
                            $stmt->bindParam(":newFilePath", $newFilePath, PDO::PARAM_STR);
                            $stmt->bindParam(":fileCategory_id", $fileCategory_id, PDO::PARAM_INT);
                            $stmt->bindParam(":fileStatus", $fileStatus, PDO::PARAM_STR);
                            $stmt->execute();

                            $successMessage = "<p id='noMargin'>File added successfully.</p>
                            File name: $fileName</br>
                            File format: $fileFormat</br>
                            File path: $newFilePath</br>
                            File category ID: $fileCategory_id</br>
                            File status: $fileStatus</br>";
                        }
                        catch(Exception $ex)
                        {
                            die("File could not be added. Error: " . $ex->getMessage());
                        }
                    }
                    else
                    {
                        echo "File could not be moved.";
                    }
                }
                else
                {
                    echo "File with that name already exists in directory.";
                }
            }
            else
            {
                echo "File type not accepted.";
            }
        }
    }

    function editFile($dbHandler, &$errors, &$successMessage, $acceptedFileTypesExtensions)
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
            SELECT * 
            FROM `file` 
            WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $existingFile = $stmt->fetch(PDO::FETCH_ASSOC);

            if($existingFile == FALSE)
            {
                echo "File not found.";
                return;
            }
            else
            {
                $oldFilePath = $existingFile['filePath'];
            }
        }
        catch(Exception $ex)
        {
            die("Could not retrieve file to be updated. Error: " . $ex->getMessage());
        }

        $fileName = filter_input(INPUT_POST, "fileName", FILTER_SANITIZE_SPECIAL_CHARS);
        $chosenDirectory = filter_input(INPUT_POST, "chosenDirectory");
        $fileCategory_id = filter_input(INPUT_POST, "fileCategory_id", FILTER_VALIDATE_INT);
        $fileStatus = filter_input(INPUT_POST, "fileStatus", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($fileName))
        {
            array_push($errors, "Please enter a file name.");
        }
        if(empty($chosenDirectory))
        {
            array_push($errors, "Please choose directory.");
        }
        if(empty($fileCategory_id) || $fileCategory_id == FALSE)
        {
            array_push($errors, "Please enter a file category.");
        }
        if(empty($fileStatus))
        {
            array_push($errors, "Please enter a file status.");
        }
        if(!isset($_FILES['uploadedFile']) || $_FILES['uploadedFile']['error'] !== 0)
        {
            array_push($errors, "Error when uploading file.");
        }

        if(empty($errors))
        {
            $fileMime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['uploadedFile']['tmp_name']);

            if(array_key_exists($fileMime, $acceptedFileTypesExtensions))
            {
                $fileFormat = $acceptedFileTypesExtensions[$fileMime];
                $fullFileName = $fileName . "." . $fileFormat;

                $filePath = "../files/" . $chosenDirectory . "/" . $fullFileName;
                
                if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $filePath))
                {
                    $absoluteOldPath = "../" . $oldFilePath;

                    if(file_exists($absoluteOldPath))
                    {
                        unlink($absoluteOldPath);
                    }

                    try
                    {
                        $newFilePath = "files/" . $chosenDirectory . "/" . $fullFileName;
                        $stmt = $dbHandler->prepare("
                        UPDATE `file` SET 
                        fileName = :fileName, 
                        fileFormat = :fileFormat, 
                        filePath = :newFilePath,
                        fileCategory_id = :fileCategory_id,
                        fileStatus = :fileStatus
                        WHERE id = :id
                        ");
                        $stmt->bindParam(":fileName", $fileName, PDO::PARAM_STR);
                        $stmt->bindParam(":fileFormat", $fileFormat, PDO::PARAM_STR);
                        $stmt->bindParam(":newFilePath", $newFilePath, PDO::PARAM_STR);
                        $stmt->bindParam(":fileCategory_id", $fileCategory_id, PDO::PARAM_INT);
                        $stmt->bindParam(":fileStatus", $fileStatus, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                        $stmt->execute();

                        $successMessage = "<p id='noMargin'>File edited successfully.</p>
                        File ID: $id</br>
                        File name: $fileName</br>
                        File format: $fileFormat</br>
                        File path: $newFilePath</br>
                        File category ID: $fileCategory_id</br>
                        File status: $fileStatus</br>";
                    }
                    catch(Exception $ex)
                    {
                        die("File could not be edited. Error: " . $ex->getMessage());
                    }
                }
                else
                {
                    echo "File could not be moved.";
                }
            }
            else
            {
                echo "File type not accepted.";
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
            SELECT filePath 
            FROM `file` 
            WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $fileToBeDeleted = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $ex)
        {
            echo "File to be deleted could not be found. Error: " . $ex->getMessage();
            return;
        }

        $absolutePath = "../" . $fileToBeDeleted['filePath'];

        if (file_exists($absolutePath))
        {
            unlink($absolutePath);
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
            addFile($dbHandler, $errors, $successMessage, $acceptedFileTypesExtensions);
        }
        elseif($action == "edit")
        {
            editFile($dbHandler, $errors, $successMessage, $acceptedFileTypesExtensions);
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
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <p>
                            <label for="uploadedFile">Choose File:</label>
                            <input type="file" name="uploadedFile" id="uploadedFile">
                        </p>
                        <p>
                            <label for="chosenDirectory">Choose Directory:</label>
                            <select id="chosenDirectory" name="chosenDirectory">
                                <option value="" selected disabled>Select an option</option>
                                <option value="feedback">Feedback</option>
                                <option value="notes">Notes</option>
                                <option value="presenting">Presenting</option>
                                <option value="proskills">Proskills</option>
                            </select>
                        </p>
                        <p>
                            <label for="fileName">File name:</label>
                            <input type="text" name="fileName" id="fileName">
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
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <p>
                            <label for="id">File ID:</label>
                            <input type="text" name="id" id="edit_id">
                        </p>
                        <p>
                            <label for="uploadedFile">Choose File:</label>
                            <input type="file" name="uploadedFile" id="uploadedFile">
                        </p>
                        <p>
                            <label for="chosenDirectory">Choose Directory:</label>
                            <select id="chosenDirectory" name="chosenDirectory">
                                <option value="" selected disabled>Select an option</option>
                                <option value="feedback">Feedback</option>
                                <option value="notes">Notes</option>
                                <option value="presenting">Presenting</option>
                                <option value="proskills">Proskills</option>
                            </select>
                        </p>
                        <p>
                            <label for="fileName">File name:</label>
                            <input type="text" name="fileName" id="fileName">
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