<?php
    require_once("../dbconnect.php");
    require_once("../includes/admin_authorise.php");

    date_default_timezone_set("Europe/Amsterdam");

    $today = date("Y-m-d");
    $currentTime = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN DASH</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/admin_overview.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
                <a id ="pfp" href="profile.php">
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
                <li id="currentPage">Admin</li>
                <li><a href='logout.php'>Log Out</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div id="mainGrid">
            <div class="gridMainOuter" id="gridTimeDate">
                <div class="gridMainMiddle">
                    <div class="gridMainInner" id="timeDate">
                        <p id="time">Time: <?php echo $currentTime; ?></p>
                        <p id="date">Date: <?php echo $today; ?></p>
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
                                <label for="todo1">Password change possibility.</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo2">
                                <label for="todo2">Maybe custom page for error messages when file is not accessible?</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo3">
                                <label for="todo3">Add file access for user roles (notes, presenting, proskills).</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo4">
                                <label for="todo4">Add projects tab?</label>
                            </li>
                            <li>
                                <input type="checkbox" id="todo5">
                                <label for="todo5">Feedback: Add Flavius and Ai's feedback.</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="gridMainOuter" id="gridLatestUpdate">
                <div class="gridMainMiddle">
                    <div class="gridMainInner">
                        <p class="fieldTitle">Lastest Update:<p>
                        <?php
                            $githubUser = "RekaSzK";
                            $repoName   = "portfolio";

                            $url = "https://api.github.com/repos/$githubUser/$repoName/commits";

                            //stream_conrext_create: extra specifications on how to fetch a URL

                            //in this case: when PHP fetches the URL, HTTP should use the header: 'User-Agent: Portfolio-Website\r\n'
                            $context = stream_context_create(
                            ["http" =>
                                [
                                "header" => "User-Agent: Portfolio-Website\r\n"
                                ]
                            ]);

                            //file_get_contents: downloads data from a URL and stores it in a variable

                            //in this case: downloads data from the URL using the extra rules specified in $context and stores it in $response
                            //'false' means that when loading files, do NOT use include_path (= do NOT search folders)
                            //$response is now a JSON string => it needs to be decoded later
                            $response = file_get_contents($url, false, $context);


                            if ($response !== false) //if the download from the URL wass successful, $response is a JSON string, otherwise it is false
                            {
                                $commits = json_decode($response, true); //decoding $response, turning it into an associative array (because of 'true', otherwise it becomes an object)

                                if (!empty($commits[0])) //if there are any commits
                                {
                                    $latestCommit = $commits[0];
                                    $message = htmlspecialchars($latestCommit['commit']['message']);
                                    $date = date(
                                        "Y-m-d H:i", //year-month-day hours-minutes
                                        strtotime($latestCommit['commit']['author']['date']) //converts the time stored as text to actual time
                                    );

                                    echo "<p><b>$message</b></p>";
                                    echo "<p class='fieldSubtitle'>Pushed on $date</p>";
                                }
                                else
                                {
                                    echo "<p>No commits found.</p>";
                                }
                            }
                            else
                            {
                                echo "<p>Could not fetch updates.</p>";
                            }
                        ?>
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
                                SELECT id, fileName
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
                                <a id="latestUploadLink" href="file_viewer.php?id=<?php echo (int)$latestUpload['id']; ?>"><?php echo htmlspecialchars($latestUpload['fileName']); ?></a>
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
                            <li><a href="file_access_manager.php">Manage File Access</a> &#8212; <a href="file_access_overview.php">File Access Overview</a></li>
                            <li><a href="category_manager.php">Manage Categories</a> &#8212; <a href="categories_overview.php">Categories Overview</a></li>
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
</html>