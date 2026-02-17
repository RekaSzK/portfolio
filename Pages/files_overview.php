<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    try
    {
        $stmt = $dbHandler->prepare("SELECT * FROM `file`");
        $stmt->execute();

        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $ex)
    {
        die("Files could not be retrived. Error: " . $ex->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FILES OVERVIEW</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/overview.css">
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
                <li><a href="projects.php">Projects</a></li>
                <li><a href='admin_overview.php'>Admin</a></li>
                <li><a href='logout.php'>Log Out</a></li>
            </ul>
        </div>
    </header>
    <main>
        <h1>Files Overview</h1>
        <table>
            <tr>
                <th>File ID</th>
                <th>File Name</th>
                <th>File Format</th>
                <th>File Path</th>
                <th>File Category ID</th>
                <th>File Status</th>
                <th>File Folder</th>
            </tr>
            <?php foreach($files as $file): ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['id']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileName']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileFormat']); ?></td>
                    <td><?php echo htmlspecialchars($file['filePath']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileCategory_id']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileStatus']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileFolder']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div id="bottomGrid">
            <div id="backToManager">
                <a href="file_manager.php">&lt; Back To Manager</a>
            </div>
        </div>
    </main>
</body>
</html>