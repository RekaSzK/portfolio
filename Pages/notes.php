<?php

    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");

    $userId = $_SESSION['userId'];
    $userRole = $_SESSION['role'];
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
            </div>
            <ul id="headerList">
                <li><a href="feedback.php">Feedback</a></li>
                <li id="currentPage">Notes</li>
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
                            if($userRole === 'admin')
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Minutes of Meetings%' AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Minutes of Mettings%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                $stmt->execute([$userId]);
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file) {
                        ?>
                            <li><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            <?php }; ?>
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
                            if($userRole === 'admin')
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE (file.fileName LIKE '%Consultation%' OR file.fileName LIKE '%Agenda%' OR file.fileName LIKE '%Interview%') AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE (file.fileName LIKE '%Consultation%' OR file.fileName LIKE '%Agenda%' OR file.fileName LIKE '%Interview%') AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                $stmt->execute([$userId]);
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file) {
                        ?>
                            <li><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            <?php }; ?>
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
                            if($userRole === 'admin')
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%' AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                $stmt->execute([$userId]);
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file) {
                        ?>
                            <li><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></li>
                            <?php }; ?>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>