<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    try
    {
        $stmt = $dbHandler->prepare("
        SELECT user.userName, file.fileName
        FROM `file_access`
            JOIN `user` ON file_access.user_id = user.id
            JOIN `file` ON file_access.file_id = file.id");
        $stmt->execute();

        $fileAccess = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $ex)
    {
        die("File access list could not be retrived. Error: " . $ex->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILE ACCESS OVERVIEW</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/overview.css">
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
                <li><a href="projects.php">Projects</a></li>
                <li><a href='admin_overview.php'>Admin</a></li>
                <li><a href='logout.php'>Log Out</a></li>
            </ul>
        </div>
    </header>
    <main>
        <h1>File Access Overview</h1>
        <table>
            <tr>
                <th>Username</th>
                <th>File Name</th>
            </tr>
            <?php foreach($fileAccess as $record): ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['userName']); ?></td>
                    <td><?php echo htmlspecialchars($record['fileName']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div id="bottomGrid">
            <div id="backToManager">
                <a href="file_access_manager.php">&lt; Back To Manager</a>
            </div>
        </div>
    </main>
</body>
</html>