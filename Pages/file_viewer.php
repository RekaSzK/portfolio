<?php
    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");

    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

    if(!$id)
    {
        die("Invalid file ID.");
    }

    try
    {
        $stmt = $dbHandler->prepare("
        SELECT filePath 
        FROM `file` 
        WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $file = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$file)
        {
            die("File not found.");
        }
    }
    catch(Exception $ex)
    {
        die("File could not be retrieved. Error: " . $ex->getMessage());
    }

    $absolutePath = "../" . $file['filePath'];

    if(!file_exists($absolutePath))
    {
        die("File not found at given absolute path.");
    }

    $fileMime = mime_content_type($absolutePath);

    $inlineTypes = ["application/pdf", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];

    if(in_array($fileMime, $inlineTypes))
    {
        $disposition = "inline";
    }
    else
    {
        $disposition = "attachment";
    }
    //Content type is binary data, the file should be treated as a [fileMime].
    header("Content-Type: $fileMime");
    //To name the file correctly
    header("Content-Disposition: $disposition; filename=" . basename($absolutePath));
    //For the browser to display more accurate download progress
    header("Content-Length: " . filesize($absolutePath));

    readfile($absolutePath);
    exit;
?>