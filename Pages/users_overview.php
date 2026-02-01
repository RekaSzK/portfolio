<?php
    require("../includes/admin_authorise.php");
    require("../dbconnect.php");

    try
    {
        $stmt = $dbHandler->prepare("SELECT * FROM `user`");
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
</head>
<body>
    <h1>Users Overview</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>User role</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['userName']); ?></td>
                <td><?php echo htmlspecialchars($user['userRole']); ?></td>
            <tr>
        <?php endforeach; ?>
    </table>
</body>
</html>