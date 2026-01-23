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
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        Optio, explicabo praesentium voluptas provident adipisci rerum id iusto expedita alias? 
                        Neque dicta eveniet aperiam saepe delectus dignissimos, facilis sed libero voluptatibus.
                    </p>
                    <p class="filesLink">
                        <?php
                            if($userRole === 'admin')
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Reflection Report - Y1P2%' AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Reflection Report - Y1P2%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                $stmt->execute([$userId]);
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file) {
                        ?>
                            <p class="queryLink"><a href="download.php?file_id=<?php echo $file['id'];?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                            <?php } ?>
                    </p>
                </div>
            </div>
            <div class="mainField">
                <div class="mainText">
                    <P class="textTitle">
                        <b>STUDY CAREER COACHING</b>
                    </p>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                        Optio, explicabo praesentium voluptas provident adipisci rerum id iusto expedita alias? 
                        Neque dicta eveniet aperiam saepe delectus dignissimos, facilis sed libero voluptatibus.
                    </P>
                    <p class="filesLink">
                        <?php
                            if($userRole === 'admin')
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file WHERE file.fileName LIKE '%Study Career Coaching - Y1P2%' AND file.fileStatus = 'approved'");
                                $stmt->execute();
                            }
                            else
                            {
                                $stmt = $dbHandler->prepare("SELECT file.id, file.fileName FROM file JOIN file_access ON file.id = file_access.file_id WHERE file.fileName LIKE '%Study Career Coaching - Y1P2%' AND file.fileStatus = 'approved' AND file_access.user_id = ?");
                                $stmt->execute([$userId]);
                            }

                            $files = $stmt->fetchAll();

                            foreach($files as $file) {
                        ?>
                            <p class="queryLink"><a href="download.php?file_id=<?php echo $file['id'];?>"><?php echo htmlspecialchars($file['fileName']); ?></a></p>
                            <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>