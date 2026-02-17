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
    <title>NOTES</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/notes.css">
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
                <li id="currentPage">Notes</li>
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
            <div id="descBox">
                <div class="mainText">
                    <p class="textTitle">
                        <b>DESCRIPTION</b> : The <i>NOTES</i> page mainly focuses on minutes taken by me, during plenaries, group meetings or otherwise. 
                        By clicking on a file name, you are able to download the file.<br>
                        There are four kinds of files showcased on this page:
                    </p>
                    <ul id="typesList">
                        <li>Plenary Notes</li>
                        <li>Minutes of Meeting</li>
                        <li>Code of Conduct</li>
                        <li>Project Plan</li>
                    </ul>
                </div>
            </div>
            <div class="mainField">
                <div class="mainText">
                    <p class="textTitle">
                        <b>PLENARY NOTES</b> : The plenary takes place weekly and is a course-wide discussion about our progress, any difficulties and announcements. 
                        The entirety of the IT year is present, as well as some lecturers.
                    </p>
                    <ul class="textLinks">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE file.fileName LIKE '%Minutes of Meetings%' 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Minutes of Meetings%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file): ?>

                            <li><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            
                            <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="mainField">
                <div class="mainText">
                    <p class="textTitle">
                        <b>MINUTES OF MEETINGS</b> : A 'minutes of meeting' refers to the notes taken by the note-taker (i. e. 'minute-taker') during meetings. 
                        The note records attendance, discussed topics and decisions made.
                    </p>
                    <ul class="textLinks">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE (file.fileName LIKE '%Consultation%' OR file.fileName LIKE '%Agenda%' OR file.fileName LIKE '%Interview%') 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE (file.fileName LIKE '%Consultation%' OR file.fileName LIKE '%Agenda%' OR file.fileName LIKE '%Interview%') 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file): ?>

                            <li><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            
                            <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="mainField">
                <div class="mainText">
                    <p class="textTitle">
                        <b>ADDITIONAL DOCUMENTS</b> : Each project has many corresponding documents. 
                        To understand our works' foundations best, find below the Code of Conduct and Project Plan of each Project.
                    </p>
                    <ul class="textLinks">
                        <?php
                            if($role == 'admin')
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file` 
                                WHERE (file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%') 
                                AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT file.id, file.fileName 
                                FROM `file`
                                    JOIN `file_access` ON file.id = file_access.file_id 
                                WHERE file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%' 
                                AND file.fileStatus = 'approved' 
                                AND file_access.user_id = :user_id");
                                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                                $stmt->execute();
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file): ?>

                            <li><a href="file_viewer.php?id=<?php echo (int)$file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            
                            <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>