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
    <title>PROFESSIONAL SKILLS</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/proskills.css">
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
                <li id="currentPage">Professional Skills</a></li>
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
            <div class="mainField">
                <div class="mainText">
                    <p class="textTitle">
                        <b>REFLECTION REPORT</b> : Year 1, Semester 1
                    </p>
                    <p>
                        To conclude Year 1, Periods 1 and 2, a Reflection Report was created. In it. I reflect on the experience 
                        I had, the learning experience and the community. I found it important to talk about the difference between 
                        the education I received at home compared to the one here in the Netherlands.
                    </p>
                    <p class="filesLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Reflection Report - Y1P2%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Reflection Report - Y1P2%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file): ?>

                            <p class="queryLink"><a href="download.php?file_id=<?php echo $file['id'];?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                            
                            <?php endforeach; ?>
                    </p>
                </div>
            </div>
            <div class="mainField">
                <div class="mainText">
                    <P class="textTitle">
                        <b>STUDY CAREER COACHING</b> : Year 1, Semester 1
                    </p>
                    <p>
                        This document contains a short description of my satisfaction with the learning outcomes and states that 
                        I intend to continue with my student career at NHL Stenden.
                    </P>
                    <p class="filesLink">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Study Career Coaching - Y1P2%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Study Career Coaching - Y1P2%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file): ?>

                            <p class="queryLink"><a href="download.php?file_id=<?php echo $file['id'];?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                            
                            <?php endforeach; ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>