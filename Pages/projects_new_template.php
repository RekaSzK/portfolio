<?php
    require_once("../includes/admin_authorise.php");
    require_once("../dbconnect.php");

    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];
?>
<div class="mainField">
    <div class="period">
        <div class="periodDetails">
            <div class="descriptionText">
                <p class="descriptionTitle"></p>
                <p class="projectYear"><i>&#8212; </i></p>
                <p class="description">

                </p>
            </div>
            <div class="descriptionLinks">
                <ul>
                    <li><a href="">GitHub repository</a></li>
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
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>

                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
                <div class="periodRotatorCard"><img src="../images/projects/y_p_/placeholder.png" alt=""></div>
            </div>
        </div>
    </div>
</div>