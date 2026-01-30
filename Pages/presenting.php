<?php

    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");

    $userId = $_SESSION['userId'];
    $userRole = $_SESSION['userRole'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRESENTING</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/presenting.css">
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
                <li id="currentPage">Presenting</li>
                <li><a href="proskills.php">Professional Skills</a></li>
                <?php
                    if($_SESSION['userRole'] == "admin")
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
            <div class="mainRow">
                <div class="mainText">
                    <div class="mainTextInner">
                        <p class="textTitle">
                            <b>YEAR 1, PERIOD 1</b> : PROJECT WEB DEVELOPMENT
                        </p>
                        <p class="textParagraph">
                            The presentation was created and presented by <b>Aynur Tozluyurt</b> and <b>myself</b>. 
                            We aimed to create a clean, polished PowerPoint, to highlight the colourful nature of our website. 
                            Included were several images of the final look of our website, icons that had been used and the colour scheme.
                        </p>
                        <ul class="presentationLink">
                            <?php
                                if($userRole === 'admin')
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Presentation - Y1P1%' AND file.fileStatus = 'approved'");
                                    $stmt->execute();
                                }
                                else
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Presentation - Y1P1%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                    $stmt->execute([$userId]);
                                }

                                $file = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <li class="queryLink"><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>

                            <?php
                                if($userRole === 'admin')
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Presentation Grading - Y1P1%' AND file.fileStatus = 'approved'");
                                    $stmt->execute();
                                }
                                else
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Presentation Grading - Y1P1%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                    $stmt->execute([$userId]);
                                }

                                $file = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <li class="queryLink"><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                        
                        </ul>
                    </div>
                </div>
                <div class="mainImg">
                    <div class="mainImgInner">
                        <img id="sunnySocksImg" src="../images/SunnySocks.png" alt="Image of the Sunny Socks Homepage">
                    </div>
                </div>
            </div>
            <div class="mainRow">
                <div class="mainImg">
                    <div class="mainImgInner">
                        <img id="TBA" src="TBA" alt="TBA">
                    </div>
                </div>
                <div class="mainText">
                    <div class="mainTextInner">
                        <p class="textTitle">
                            <b>YEAR 1, PERIOD 2</b> : PROJECT DATABASE APPLICATION MANAGEMENT
                        </p>
                        <p class="textParagraph">
                            The final assessment did not require a presentation, as it was a group effort. 
                            The project concluded with a success as all three team members passed.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mainRow">
                <div class="mainText">
                    <div class="mainTextInner">
                        <p class="textTitle">
                            <b>YEAR 1, PERIOD 2</b> : PROFESSIONAL SKILLS ASSESSMENT
                        </p>
                        <p class="textParagraph">
                            The presentation was created by me and aimed to showcase my experience during the first semester at university. 
                            I highlighted differences between the education I had been used to, compared to the one I am receiving. 
                            The colour scheme and designs reflected my personal taste, as well as the presenting style.
                        </p>
                        <ul class="presentationLink">
                            <?php
                                if($userRole === 'admin')
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Presentation - Y1P2%' AND file.fileStatus = 'approved'");
                                    $stmt->execute();
                                }
                                else
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Presentation - Y1P2%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                    $stmt->execute([$userId]);
                                }

                                $file = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <li class="queryLink"><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>

                            <?php
                                if($userRole === 'admin')
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Presentation Grading - Y1P2%' AND file.fileStatus = 'approved'");
                                    $stmt->execute();
                                }
                                else
                                {
                                    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Presentation Grading - Y1P2%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                    $stmt->execute([$userId]);
                                }

                                $file = $stmt->fetch(PDO::FETCH_ASSOC);
                            ?>

                            <li class="queryLink"><a href="download.php?file_id=<?php echo $file['id']; ?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                        
                        </ul>
                    </div>
                </div>
                <div class="mainImg">
                    <div class="mainImgInner">
                        <img id ="" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>