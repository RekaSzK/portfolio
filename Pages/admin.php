<?php
    require_once("../includes/admin_authorise.php");
    require_once("../dbconnect.php");

    $stmt = $dbHandler->prepare("SELECT file.id, file.fileName, file.fileStatus FROM file ORDER BY file.fileStatus ASC");
    $stmt->execute();

    $files = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASH</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php echo "ADMIN HEY"; ?>
</body>
</html>