<?php
    if(!empty($_POST["email"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["c_password"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "test") or die("Connessione fallita: " . mysqli_error($conn));
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $username =  mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);

        $error = array();
        
        //Verifica che l'username rispetti il pattern specificato o che non sia già stato utilizzato
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) 
        {
            $error[] = "Username non valido";
        } 
        else 
        {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);

            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }

        //Verifica che la password abbia la giusta lunghezza
        if (strlen($_POST["password"]) < 5) 
            $error[] = "Inserisci una password di almeno 5 caratteri";

        //Verifica che la password contenga almeno un carattere minuscolo, uno maiuscolo e un numero
        if (!preg_match("#[0-9]+#", $_POST["password"]) || !preg_match("#[a-z]+#", $_POST["password"]) || !preg_match("#[A-Z]+#", $_POST["password"])) 
            $error[] = "La password deve contenere almeno un carattere minuscolo, uno maiuscolo e un numero";

        //Verifica che la password non contenga caratteri speciali
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $_POST["password"])) 
            $error[] = "La password non può contenere caratteri speciali";

        //Verifica che la password e la conferma coincidano
        if (strcmp($_POST["password"], $_POST["c_password"]) != 0) 
            $error[] = "Le password non coincidono";
        

        //Verifica che la mail sia valida e che non sia già stata utilizzata
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {
            $error[] = "Email non valida";
        } 
        else 
        {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

            if (mysqli_num_rows($res) > 0) 
                $error[] = "Email già utilizzata";
        }

        //Verifica che non ci siano stati errori e inserisce eventualmente l'utente nel database
        if(count($error) === 0)
        {
            $query = "INSERT INTO users(email, username, password) VALUES('$email', '$username', '$password')";
            
            if (mysqli_query($conn, $query)) 
            {
                session_start();
                $_SESSION["username"] = $_POST["username"];
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } 
            else 
                $error[] = "Errore di connessione al Database";
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) 
        $error = array("Riempi tutti i campi");
?>

<html>
    <head>
        <title>GameBase: registrazione</title>
        <link rel = "stylesheet" href = "registrazione.css">
        <script src = "registrazione.js" defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <style>@import url('https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap');</style>
    </head>
    <body id="body">
        <div id="box">
            <p id="title">GameBase</p>
            <main id="main">
                <?php if(isset($error))
                        foreach($error as $err) 
                            echo "<div id='errore'><span>".$err."</span></div>";
                ?>
                <form id="form" name = 'nome_form' method = 'POST'>

                    <h4 id="size-h4">Registrazione</h4>

                    <div id="email">
                        <label for="email">Email:</label><input class="space" type = 'text' name = 'email'>
                        <div class="errordiv"><span></span></div>
                    </div>

                    <div id="username">
                        <label for="username">Username:</label><input class="space" type = 'text' name = 'username'>
                        <div class="errordiv"><span></span></div>
                    </div>
             
                    <div id="password">
                        <label for="password">Password:</label><input class="space" type = 'password' name = 'password'>
                        <div class="errordiv"><span></span></div>
                    </div>

                    <div id="c_password">
                        <label for="c_password">Conferma password:</label><input class="space" type = 'password' name = 'c_password'>
                        <div class="errordiv"><span></span></div>
                    </div>

                    <input id="submit" type = 'submit' value = 'Registrati'>

                </form>
                <h6 id="size-h6">Hai già un account? <a id="link" href = "login.php">Accedi</a></h6>
            </main>
        </div>
    </body>
</html>