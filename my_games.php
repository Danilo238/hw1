<?php

    session_start();
    if(isset($_SESSION["username"]))
    {
        $conn = mysqli_connect("localhost", "root", "", "test");
        $username = $_SESSION["username"];
        $query = "SELECT id FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query);
        $id = mysqli_fetch_array($res);        

        $query = "SELECT id_game FROM preferiti WHERE id_user = '$id[0]'";
        $result = mysqli_query($conn, $query);
        mysqli_close($conn);
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($result);
    }
    
?>