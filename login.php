<?php
    //Avvia la sessione
    session_start();

    //Verifica se l'utente è già loggato
    if(isset($_SESSION["username"]))
    {
        //Vai alla home
        header("Location: home.php");
        exit;
    }

    //Verifica esistenza dati
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        //Connessione al DB
        $conn = mysqli_connect("localhost", "root", "", "test") or die(mysqli_error($conn));
        //Salvataggio delle variabili di accesso
        $username =  mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        //Preparazione query
        $query = "select * from users where username = '".$username."' and password = '".$password."'";
        //Esecuzione query
        $res = mysqli_query($conn, $query);

        //Verficica correttezza credenziali
        if(mysqli_num_rows($res) > 0)
        {
            //Salvataggio username nella sessione
            $_SESSION["username"] = $username;
            //Vai alla home
            header("Location: home.php");
            exit;
        }
        else
        {
            //Credenziali errate
            $errore = true;
        }
    }
?>

<html>
    <head>
        <title>GameBase: login</title>
        <link rel = "stylesheet" href = "login.css">
        <script src = "login.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>@import url('https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap');</style>
    </head>
    <body id="body">
        <div id="box">
            <p id="title">GameBase</p>
            <main id="main">

                <?php
                    if(isset($errore))
                    {
                        echo '<p id="errore">';
                        echo "Credenziali errate";
                        echo "</p>";
                    }
                ?>

                <form id="form" name = 'nome_form' method = 'POST'>

                    <div id="username">
                        <label for="username">Username:</label><input class="space" type = 'text' name = 'username'>
                    </div>

                    <div id="password">
                        <label for="password">Password:</label><input class="space" type = 'password' name = 'password'>
                    </div>

                    <div id="error" class="hidden"><span></span></div>

                    <input id="submit" type = 'submit' value = 'Accedi'>

                </form>

                <h5>Non ancora registrato ? <a id="link" href = registrazione.php>Clicca qui</a></h5>
            </main>
        </div>
    </body>
</html>