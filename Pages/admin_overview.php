<?php
    require_once("../includes/admin_authorise.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASH</title>
    <link rel="stylesheet" href="../css/admin_overview.css">
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
        <div id="mainGrid">
            <div class="gridMainOuter" id="gridTtimeDate">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p>Time:</p>
                        <p>Date:</p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridGreeting">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p id="adminGreeting">
                            Welcome Back, Admin.
                        </p>
                        <p id="adminSubtitle">
                            What can I help you with today?
                        </p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridToDo">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">To Do:</p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridLatestUpdate">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">Lastest Update:<p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridLatestUpload">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">Latest Upload:</p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridManageDatabase">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">Manage Database:</p>
                    </div>
                </div>
            </div>
            <div class="gridMainOuter" id="gridTBA">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">TBA</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>