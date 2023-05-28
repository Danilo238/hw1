<?php

    session_start();
    
    $conn = mysqli_connect("localhost", "root", "", "test") or die(mysqli_error($conn));
    $username = $_SESSION["username"];
    $gameId = $_GET["gameId"];
    $query = "SELECT id from users WHERE username = '$username'";
    $res= mysqli_query($conn, $query);
    $userId = mysqli_fetch_assoc($res)["id"];
    $query = "DELETE FROM preferiti WHERE id_user = '$userId' AND id_game = '$gameId'";
    mysqli_query($conn, $query)

?>