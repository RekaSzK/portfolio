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
                <th>File name</th>
                <th>File format</th>
                <th>File path</th>
                <th>File category ID</th>
                <th>File status</th>
            </tr>
            <?php foreach($files as $file): ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['id']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileName']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileFormat']); ?></td>
                    <td><?php echo htmlspecialchars($file['filePath']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileCategory_id']); ?></td>
                    <td><?php echo htmlspecialchars($file['fileStatus']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>