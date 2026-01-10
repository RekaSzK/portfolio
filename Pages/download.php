<?php
    session_start();
    require "../dbconnect.php";

    if(!isset($_SESSION['userId']))
    {
        header("Location: login.php");
        exit;
    }
    if(!isset($_GET['file_id']))
    {
        die("No file specified.");
    }

    $fileId = (int)$_GET['file_id'];
    $userId = $_SESSION['userId'];
    $userRole = $_SESSION['userRole'];

    $stmt = $dbHandler->prepare("SELECT * FROM `file` WHERE id = ? AND fileStatus = 'approved'");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch();

    if(!$file)
    {
        die("File not found or not approved.");
    }

    if($userRole !== "admin")
    {
        $stmt = $dbHandler->prepare("SELECT * FROM `file_access` WHERE file_id = ? AND user_id = ?");
        $stmt->execute([$fileId, $userId]);
        if(!$stmt->fetch())
        {
            die("You do not have access to this file.");
        }
    }

    $filePath = "../" . $file['filePath'];

    if(!file_exists($filePath))
    {
        die("File missing on server.");
    }

    //Content type is binary data, should be treated as a download.
    header('Content-Type: application/octet-stream');
    //To name the file correctly
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    //For the browser  to display more accurate download progress
    header('Content-Length: ' . filesize($filePath));
    
    //Opens a specific file
    readfile($filePath);
    exit;
?>