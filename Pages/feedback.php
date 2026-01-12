<?php
    require_once("../includes/authorise.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEEDBACK</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/feedback.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a href="index.php">HOME</a>
            </div>
            <ul id="headerList">
                <li id="currentPage">Feedback</li>
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
            <div class="mainGridCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P2 TEAMMATE
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P1 TEAMMATE
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
            </div>
            <div class="mainGridCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P2 TEAMMATE
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P1 STUDY BUDDY
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
            </div>
            <div class="mainGridCol">
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P2 TEAMMATE
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
                <div class="feedbackInGrid">
                    <p class="feedbackTitle">
                        <b>FEEDBACK FROM</b> :</br>P1 TEAMMATE
                    </p>
                    <p class="feedbackText">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Etiam lorem magna, auctor vel eleifend id, tristique sed purus. 
                        Proin ornare sollicitudin tincidunt. In facilisis nisl sapien, a rutrum velit porta vitae. 
                        Aenean urna orci, sollicitudin venenatis lorem sed, aliquam consequat eros. 
                        Morbi posuere sem a mi blandit, a eleifend felis ullamcorper. 
                        Fusce sit amet tortor vitae magna lobortis consectetur. 
                        Pellentesque fermentum, leo vitae maximus pulvinar.
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>