<?php

    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost", "root", "", "test") or die("Connessione fallita: " . mysqli_error($conn));

    $username = mysqli_real_escape_string($conn, $_GET["username"]);

    $query = "SELECT username FROM users WHERE username = '$username'";
        
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_close($conn);
    
?>