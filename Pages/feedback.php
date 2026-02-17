<?php

    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");

    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEEDBACK</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/feedback.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
            </div>
            <ul id="headerList">
                <li id="currentPage">Feedback</li>
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
        <div id="mainGrid">
            <div class="mainGridCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Rodrigo de Araújo Castanheira
                    </p>
                    <p class="feedbackText">
                        <i>Teammate during <b>Project Database Management</b> in Year 1, Period 2</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Rodrigo%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Rodrigo%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Aynur Tozluyurt
                    </p>
                    <p class="feedbackText">
                        <i>Teammate during <b>Project Web Development</b> in Year 1, Period 1</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName  
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Aynur%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Aynur%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
            </div>
            <div class="mainGridCol" id="studyBuddyCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Flavius Petraşciuc
                    </p>
                    <p class="feedbackText">
                        <i>Study buddy during <b>Project Database Management</b> in Year 1, Period 2</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Flavius%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Flavius%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Ai Nguyen
                    </p>
                    <p class="feedbackText">
                        <i>Study buddy during <b>Project Web Development</b> in Year 1, Period 1</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName, file.fileFormat, file.fileFolder 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Ai%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName, file.fileFormat, file.fileFolder 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Ai%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            $fileName = $file['fileName'] . "." . $file['fileFormat'];
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
            </div>
            <div class="mainGridCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Jakub Mazur
                    </p>
                    <p class="feedbackText">
                        <i>Teammate during <b>Project Database Management</b> in Year 1, Period 2</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Jakub%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Jakub%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>Oleksii Khomiak
                    </p>
                    <p class="feedbackText">
                        <i>Teammate during <b>Project Database Management</b> in Year 1, Period 1</i>
                    </p>
                    <p class="feedbackLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Feedback From Oleksii%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Feedback From Oleksii%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $file = $stmt->fetch();
                            ?>

                        <p class="queryLink"><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>