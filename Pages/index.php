<?php
    require_once("../includes/authorise.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="icon" type="image/ico" href="../images/icon.png">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <header>
        <div id="headerGrid">
            <div id="headerHome">
                <a>HOME</a>
            </div>
            <ul id="headerList">
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="notes.php">Notes</a></li>
                <li><a href="presenting.php">Presenting</a></li>
                <li><a href="proskills.php">Professional Skills</a></li>
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
        <div id="mainGrid">
            <div id="mainLeft">
                <div id="mainLeftField">
                    <div id="innerMainLeft">
                        <p id="mainLeftTitle">
                            BIOGRAPHY : Réka Szunyogh-Kocsis
                        </p>
                        <p>
                            Hello, and welcome to my website! My full name is Réka Laura Szunyogh-Kocsis, 
                            a first-year IT student at NHL Stenden University of Applied Sciences. I am 
                            from Budapest, Hungary, currently studying in Emmen, The Netherlands.
                        </p>
                        <p>
                            This website aims to showcase my university work and provide information about my work ethic.<br>
                            Using <b>FEEDBACK</b>, you can find out what people in my life have to say about me, whether 
                            professionally or personally.<br>
                            On the <b>NOTES</b> page, you can find all of my approved minutes of meetings and plenary notes.<br>
                            The <b>CONTACT</b> tab provides you with a form, through which you can provide me with any kind of 
                            feedback you might have.<br>
                            Lastly, <b>FILES</b> contains all of my assignments, if you wish to take a look at them.
                        </p>
                        <p id="mainLeftLowerParagraph">
                            Thank you for your visit. I hope you find everything you're looking for.
                        </p>
                    </div>
                </div>
            </div>
            <div id="mainRight">
                <div id="mainRightImage">
                    <img id="portrait" src="../images/portrait.jpg" alt="Portrait">
                    <a target="_blank" href="https://github.com/RekaSzK"><img id="githubIcon" src="../images/githubicon.png" alt="GitHub Icon"></a>
                    <a target="_blank" href="https://www.linkedin.com/in/r%C3%A9ka-szunyogh-kocsis-993849180/"><img id="linkedinIcon" src="../images/linkedinicon.png" alt="Linked In Icon"></a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>