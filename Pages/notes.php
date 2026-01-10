<?php

    session_start();
    require "../dbconnect.php";

    if (!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit;
    }

    $userId = $_SESSION['userId'];
    $userRole = $_SESSION['userRole'];
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
                <a href="index.html">HOME</a>
            </div>
            <ul id="headerList">
                <li><a href="feedback.html">Feedback</a></li>
                <li id="currentPage">Notes</li>
                <li><a href="presenting.html">Presenting</a></li>
                <li><a href="proskills.html">Professional Skills</a></li>
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
                        The entirety of the IT year is present, as well as some lecturers.<br>
                        Plenary notes taken by me:
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
                        The note records attendance, discussed topics and decisions made.<br>
                        Minutes, meeting agendas and schedules made by me:
                    </p>
                    <ul class="textLinks">
                        <li><a href="../files/notes/Minutes of Consultation Meeting - 10.07.doc">Consultation Meeting Minutes - 10.07.</a></li>
                        <li><a href="../files/notes/Meeting Agenda - 11.28.docx">Meeting Agenda - 11.28.</a></li>
                        <li><a href="../files/notes/Interview Schedule - 11.28.docx">Interview Schedule - 11.28.</a></li>
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
                        <li><a href="../files/notes/Code of Conduct - Y1P1.docx">Year 1, Project Web Development - Code of Conduct</a></li>
                        <li><a href="../files/notes/Project Plan - Y1P1.docx">Year 1, Project Web Development - Project Plan</a></li>
                        <li><a href="../files/notes/Code of Conduct - Y1P2.docx">Year 1, Project Database Application Management - Code of Conduct</a></li>
                        <li><a href="../files/notes/Project Plan - Y1P2.docx">Year 1, Project Database Application Management - Project Plan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>