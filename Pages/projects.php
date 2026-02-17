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
    <title>PROJECTS</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/projects.css">
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
                <li><a href="notes.php">Notes</a></li>
                <li><a href="presenting.php">Presenting</a></li>
                <li><a href="proskills.php">Professional Skills</a></li>
                <li id="currentPage">Projects</li>
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
        <div id="mainLayout">
            <div class="mainField">
                <div class="period">
                    <div class="periodDetails">
                        <div class="descriptionText">
                            <p class="descriptionTitle">PROJECT DATABASE APPLICATION MANAGEMENT</p>
                            <p class="projectYear"><i>&#8212; Year 1, Period 2</i></p>
                            <p class="description">
                                The main focuses of the project were learning about how networks 
                                work, what elements they consists of and how those elements communicate. 
                                Assigning IP addresses using DHCP, creating a custom website and database 
                                as well as setting up file sharing for the whole company based on user 
                                roles were the main parts of the project's scope.
                            </p>
                        </div>
                        <div class="descriptionLinks">
                            <ul>
                                <?php
                                    if($role == 'admin')
                                    {
                                        $stmt = $dbHandler->prepare("
                                        SELECT file.id, file.fileName 
                                        FROM `file` 
                                        WHERE file.fileCategory_id = 2 
                                        AND (file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%')
                                        AND file.fileStatus = 'approved'");
                                        $stmt->execute();
                                    }
                                    else
                                    {
                                        $stmt = $dbHandler->prepare("
                                        SELECT file.id, file.fileName 
                                        FROM `file` 
                                            JOIN `file_access` ON file.id = file_access.file_id 
                                        WHERE file.fileCategory_id = 2 
                                        AND (file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%')
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
                    <div class="periodRotatorContainer">
                        <div class="periodRotatorTrack">
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image1.png" alt="Gemorskos Website"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image2.png" alt="DHCP Setup"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image3.png" alt="Dynamic background"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image4.png" alt="Gemorskos domain"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image5.png" alt="Database preview"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image6.png" alt="Accessing database"></div>

                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image1.png" alt="Gemorskos Website"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image2.png" alt="DHCP Setup"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image3.png" alt="Dynamic background"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image4.png" alt="Gemorskos domain"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image5.png" alt="Database preview"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p2/image6.png" alt="Accessing database"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mainField">
                <div class="period">
                    <div class="periodDetails">
                        <div class="descriptionText">
                            <p class="descriptionTitle">PROJECT WEB DEVELOPMENT</p>
                            <p class="projectYear"><i>&#8212; Year 1, Period 1</i></p>
                            <p class="description">
                                The project was completed in groups of six, and the end result 
                                was a website for Sunny Socks, a company that aims to showcase 
                                their products and philosophy through a colourful website. As our 
                                first assignment, the project introduced us to programming and 
                                web development as well as proper teamwork and documentation.
                            </p>
                        </div>
                        <div class="descriptionLinks">
                            <ul>
                                <li><a href="https://github.com/Tamaskiss-ux/Sunny-Socks-project">GitHub repository</a></li>
                                <?php
                                    if($role == 'admin')
                                    {
                                        $stmt = $dbHandler->prepare("
                                        SELECT file.id, file.fileName 
                                        FROM `file` 
                                        WHERE file.fileCategory_id = 1 
                                        AND (file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%')
                                        AND file.fileStatus = 'approved'");
                                        $stmt->execute();
                                    }
                                    else
                                    {
                                        $stmt = $dbHandler->prepare("
                                        SELECT file.id, file.fileName 
                                        FROM `file` 
                                            JOIN `file_access` ON file.id = file_access.file_id 
                                        WHERE file.fileCategory_id = 1 
                                        AND (file.fileName LIKE '%Code of Conduct%' OR file.fileName LIKE '%Project Plan%')
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
                    <div class="periodRotatorContainer">
                        <div class="periodRotatorTrack">
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image1.png" alt="Sunny Socks Homepage"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image2.png" alt="Sunny Socks Homepage"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image3.png" alt="Sunny Socks Products Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image4.png" alt="Sunny Socks Sustainability Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image5.png" alt="Sunny Socks Contact Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image6.png" alt="Sunny Socks About Us Page"></div>

                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image1.png" alt="Sunny Socks Homepage"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image2.png" alt="Sunny Socks Homepage"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image3.png" alt="Sunny Socks Products Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image4.png" alt="Sunny Socks Sustainability Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image5.png" alt="Sunny Socks Contact Page"></div>
                            <div class="periodRotatorCard"><img src="../images/projects/y1p1/image6.png" alt="Sunny Socks About Us Page"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>