<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    try
    {
        $stmt = $dbHandler->prepare("
        SELECT user.id, user.userName, role.roleName 
        FROM `user`
            JOIN `role` ON user.role_id = role.id");
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $ex)
    {
        die("Users could not be retrived. Error: " . $ex->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS OVERVIEW</title>
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
        <h1>Users Overview</h1>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>User Role</th>
            </tr>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['userName']); ?></td>
                    <td><?php echo htmlspecialchars($user['roleName']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div id="bottomGrid">
            <div id="backToManager">
                <a href="user_manager.php">&lt; Back To Manager</a>
            </div>
        </div>
    </main>
</body>
</html>