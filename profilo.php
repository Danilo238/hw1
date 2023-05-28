<?php

    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit;
    }
    else
    {
        $conn = mysqli_connect("localhost", "root", "", "test");
        $query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."'";
        $res = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res);
    }

?>

<html>
    <head>
        <link rel="stylesheet" href="profilo.css">
        <script src="profilo.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk&display=swap');</style>
        <script src="https://kit.fontawesome.com/abb156a6d7.js" crossorigin="anonymous"></script>
    </head>
    <body id="body">
        <nav id="navbar">

            <div>
                <a href="home.php" id="logo">GameBase</a>
            </div>

            <div id="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>

            <ul>
                <li class="link"><a href="home.php">Home</a></li>
                <li class="link"><a href="explore.php">Explore</a></li>
                <?php
                    if(isset($_SESSION["username"])) 
                    {
                        echo "<li class='link'><a href='profilo.php'>";
                        echo $_SESSION["username"];
                        echo "</a></li>";
                    }
                ?>
                <?php 
                    if(isset($_SESSION["username"])) 
                        echo "<li class='link'><a href='logout.php'>Logout</a></li>";
                    else
                        echo "<li class='link'><a href='login.php'>Accedi</a></li>";
                ?>
            </ul>

        </nav>

        <header id="header">
            <div id="header-content">
                <h1>Profilo: <?php echo $userinfo["username"] ?></h1>
                <h3>E-email: <?php echo $userinfo["email"] ?></h3>
            </div>
        </header>

        <section id="loading-section">
            <div id="loading">
                <p>Carico i tuoi giochi</p>
                <span>.</span>
                <span>.</span>
                <span>.</span>
            </div>
        </section>
                
        <section id="my-games">
        </section>

        <section id="modal-view">
        </section>

        <footer id="footer">
            <div><span>Powered by <strong>IGDB</strong></span></div>
            <div>
            <a class="up" href=""><i class="fa-brands fa-instagram" style="color: #ffffff;padding-left: 10px;"></i></a>
            <a class="up" href=""><i class="fa-brands fa-facebook-f" style="color: #ffffff;padding-left: 10px;"></i></a>
            <a class="up" href=""><i class="fa-brands fa-youtube" style="color: #ffffff;padding-left: 10px;"></i></a>
            </div>
        </footer>

    </body>
</html>