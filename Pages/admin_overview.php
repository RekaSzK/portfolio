<?php
    require_once("../dbconnect.php");
    require_once("../includes/admin_authorise.php");

    function displayDate()
    {
        date_default_timezone_set("Europe/Amsterdam");

        $today = date("Y-m-d");
        $currentTime = date("H:i:s");

        return [$today, $currentTime];
    }
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
                    if($_SESSION['userRole'] == "admin")
                    {
                        echo "<li id='currentPage'>Admin</li>";
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
        <div id="mainGrid">

            <div class="gridMainOuter" id="gridTimeDate">
                <div class="gridMainMiddle">
                    <div class="gridMainInner" id="timeDate">
                        <p id="time">Time: <?php echo displayDate()[1]; ?></p>
                        <p id="date">Date: <?php echo displayDate()[0]; ?></p>
                    </div>
                </div>
            </div>

            <div class="gridMainOuter" id="gridGreeting">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p id="adminGreeting">
                            Welcome Back, Admin.
                        </p>
                        <p class="fieldSubtitle" id="adminSubtitle">
                            What can I help you with today?
                        </p>
                    </div>
                </div>
            </div>

            <div class="gridMainOuter" id="gridToDo">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">To Do:</p>
                        <ul id="toDoList">
                            <li>
                                <input type="checkbox" id="todo1">
                                <label for="todo1">Blur effect on page background with cursor pointer effect</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo2">
                                <label for="todo2">Fileuploader on admin side</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo3">
                                <label for="todo3">Ferrari 2026 WDC trust xx</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo4">
                                <label for="todo4">Change DB - no enum for userRole</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo5">
                                <label for="todo5">Hover effects for all cards</label>
                            </li>
                        </ul>
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
                        <?php
                            try
                            {
                                $stmt = $dbHandler->prepare("
                                SELECT id, fileName, filePath
                                FROM `file`
                                ORDER BY id DESC
                                LIMIT 1");
                                $stmt->execute();
                                $latestUpload = $stmt->fetch(PDO::FETCH_ASSOC);
                            }
                            catch(Exception $ex)
                            {
                                echo "File could not be retrieved. Error: " . $ex->getMessage();
                            }

                            if($latestUpload): ?>
                                <a id="latestUploadLink" href="<?php echo htmlspecialchars($latestUpload['filePath']); ?>"><?php echo htmlspecialchars($latestUpload['fileName']); ?></a>
                            <?php else: ?>
                                <p>No files uploaded yet.</p>
                            <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="gridMainOuter" id="gridManageDatabase">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">Manage Database:</p>
                        <p class="fieldSubtitle">&#8212; Manage entries:</p>
                        <ul id="manager">
                            <li><a href="user_manager.php">Manage Users</a> &#8212; <a href="users_overview.php">Users Overview</a></li>
                            <li><a href="file_manager.php">Manage Files</a> &#8212; <a href="files_overview.php">Files Overview</a></li>
                            <li>Manage File Permissions</li>
                            <li>Manage Categories</li>
                        </ul>
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
<script>
    function updateTime()
    {
        const now = new Date();

        const time = now.toLocaleTimeString([],
        {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });

        const timeDisplay = document.getElementById('time');
        console.log(timeDisplay)

        if(timeDisplay)
        {
            timeDisplay.textContent = `Time: ${time}`;
        }
    }

    setInterval(()=> {updateTime();}, 1000);
    
</script>