<?php
    session_start();
?>

<html>

    <head>
        <title>GameBase: i tuoi giochi preferiti</title>
        <link rel = "stylesheet" href = "home.css">
        <script src = "home.js" defer></script>
        <style>@import url('https://fonts.googleapis.com/css2?family=Space+Grotesk&display=swap');</style>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
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
                    {
                        echo "<li class='link'><a href='login.php'>Accedi</a></li>";
                        echo "<li class='link'><a href='signup.php'>Registrati</a></li>";
                    }
                ?>
            </ul>

        </nav>

        
        <header id="header">
            <form name ='search_content' id="search_content">
			    <h1>Cerca i tuoi giochi preferiti</h1>
                <div id="search_bar">
			        <label for ="content" >Cerca gioco: </label> <input type='text' name = 'content' id ="content">
			        <input class="submit" type='submit'>
                </div>		
		    </form>
        </header>

        <section id="loading-section">
            <div id="loading">
                <p>Inserisci il nome di un gioco</p>
                <span>.</span>
                <span>.</span>
                <span>.</span>
            </div>
        </section>

        <section id="game-view">
		</section>

		<article id="modal-view" class="hidden"> 	
		</article>

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