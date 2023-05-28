<?php

    session_start();
    if(isset($_SESSION["username"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "test") or die(mysqli_error($conn));
        $username = $_SESSION["username"];
        $gameId = $_GET["gameId"];
        $query = "SELECT id from users WHERE username = '$username'";
        $res= mysqli_query($conn, $query);
        $userId = mysqli_fetch_assoc($res)["id"];
        $query = "SELECT * FROM preferiti WHERE id_user = '$userId' AND id_game = '$gameId'";
        $res = mysqli_query($conn, $query);
        if(mysqli_num_rows($res) == 1)
        {
            echo json_encode(true);
        }
        else
            echo json_encode(false);
    }
    else
        echo json_encode(false);

?>