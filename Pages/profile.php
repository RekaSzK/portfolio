<?php
    require_once("../includes/authorise.php");
    require_once("../dbconnect.php");
    
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];
    $userName = $_SESSION['userName'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
                <a id ="pfp">
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
        <div id="mainField">
            <div id="mainContainer">
                <div id="mainFlex">
                    <p id="title">Your Profile</p>
                    <ul id="userData">
                        <li id="topListItem">Username: <b><?php echo $userName; ?></b></li>
                        <li>Role: <b><?php echo $role; ?></b></li>
                        <li><i><a href="change_password.php">Change Password</a></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>
</html>