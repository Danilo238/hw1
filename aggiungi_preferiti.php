<?php

    //Aggiungo ai preferiti il gioco selezionato
    session_start();
    if(isset($_SESSION["username"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "test") or die(mysqli_error($conn));
        $username = $_SESSION["username"];
        $gameName = $_GET["gameName"];
        $gameId = $_GET["gameId"];
        $query = "SELECT id from users WHERE username = '$username'";
        $res= mysqli_query($conn, $query);
        $userId = mysqli_fetch_assoc($res)["id"];
        $query = "SELECT id from games WHERE id = '$gameId'";
        if(mysqli_num_rows(mysqli_query($conn, $query)) == 0)
        {
            $query = "INSERT INTO games(id, name) VALUES ('$gameId', '$gameName')";
            mysqli_query($conn, $query);
        }
        $query = "INSERT INTO preferiti(id_user, id_game) VALUES ('$userId', '$gameId')";
        if(mysqli_query($conn, $query))
        {
            echo json_encode(true);
        }
        else
            echo json_encode(false);
            
        mysqli_close($conn);
    }
    else
        echo json_encode(false);

?>