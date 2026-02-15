<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    $errors = array();

    $successMessage = "";

    function addCategory($dbHandler, &$errors, &$successMessage) //The & makes it so that the function is pass by reference, not by value. This ensures that the $errors array and $successMessage are actually modified not just within the function, but outside of it too.
    {
        $categoryName = filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_SPECIAL_CHARS);
        $categoryYear_id = filter_input(INPUT_POST, "categoryYear_id", FILTER_VALIDATE_INT);

        if(empty($categoryName))
        {
            array_push($errors, "Please enter a category name.");
        }
        if(empty($categoryYear_id) || $categoryYear_id == FALSE)
        {
            array_push($errors, "Please enter a category year ID.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                INSERT INTO `category` (categoryName, categoryYear_id)
                VALUES (:categoryName, :categoryYear_id)
                ");
                $stmt->bindParam(":categoryName", $categoryName, PDO::PARAM_STR);
                $stmt->bindParam(":categoryYear_id", $categoryYear_id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>Category added successfully.</p>
                Category name: $categoryName</br>
                Category year ID: $categoryYear_id</br>";
            }
            catch(Exception $ex)
            {
                die("Category could not be added. Error: " . $ex->getMessage());
            }
        }
    }

    function editCategory($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid category ID.");
        }

        $categoryName = filter_input(INPUT_POST, "categoryName", FILTER_SANITIZE_SPECIAL_CHARS);
        $categoryYear_id = filter_input(INPUT_POST, "categoryYear_id", FILTER_VALIDATE_INT);

        if(empty($categoryName))
        {
            array_push($errors, "Please enter a category name.");
        }
        if(empty($categoryYear_id) || $categoryYear_id == FALSE)
        {
            array_push($errors, "Please enter a category year ID.");
        }

        if(empty($errors))
        {
            try
            {
                $stmt = $dbHandler->prepare("
                UPDATE `category` SET 
                categoryName = :categoryName, 
                categoryYear_id = :categoryYear_id
                WHERE id = :id
                ");
                $stmt->bindParam(":categoryName", $categoryName, PDO::PARAM_STR);
                $stmt->bindParam(":categoryYear_id", $categoryYear_id, PDO::PARAM_INT);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                $successMessage = "<p id='noMargin'>Category edited successfully.</p>
                Category ID: $id</br>
                Category name: $categoryName</br>
                Category year ID: $categoryYear_id</br>";
            }
            catch(Exception $ex)
            {
                die("Category could not be edited. Error: " . $ex->getMessage());
            }
        }
    }

    function deleteCategory($dbHandler, &$errors, &$successMessage)
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if($id == NULL || $id == FALSE)
        {
            array_push($errors, "Invalid category ID.");
            return;
        }

        try
        {
            $stmt = $dbHandler->prepare("
            DELETE FROM `category` 
            WHERE id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $successMessage = "<p id='noMargin'>Category deleted successfully.</p>
            Category ID: $id";
        }
        catch(Exception $ex)
        {
            die("Category could not be deleted. Error: " . $ex->getMessage());
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_SPECIAL_CHARS);

        if($action == "add")
        {
            addCategory($dbHandler, $errors, $successMessage);
        }
        elseif($action == "edit")
        {
            editCategory($dbHandler, $errors, $successMessage);
        }
        elseif($action == "delete")
        {
            deleteCategory($dbHandler, $errors, $successMessage);
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
    <title>CATEGORY MANAGER</title>
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
                    <p class="fieldTitle">Add Category</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="categoryName">Category name:</label>
                            <input type="text" name="categoryName" id="categoryName">
                        </p>
                        <p>
                            <label for="categoryYear_id">Category year ID:</label>
                            <input type="text" name="categoryYear_id" id="categoryYear_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="add">Add New Category</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Edit Category</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">Category ID:</label>
                            <input type="text" name="id" id="edit_id">
                        </p>
                        <p>
                            <label for="categoryName">Category name:</label>
                            <input type="text" name="categoryName" id="categoryName">
                        </p>
                        <p>
                            <label for="categoryYear_id">Category year ID:</label>
                            <input type="text" name="categoryYear_id" id="categoryYear_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="edit">Edit Category</button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="innerField">
                <div class="modifyField">
                    <p class="fieldTitle">Delete Category</p>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <p>
                            <label for="id">Category ID:</label>
                            <input type="text" name="id" id="delete_id">
                        </p>
                        <p>
                            <button type="submit" name="action" value="delete">Delete Category</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div id="bottomGrid">
            <div id="backToOverview">
                <a href="categories_overview.php">&lt; Back To Overview</a>
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