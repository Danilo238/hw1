<?php

    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost", "root", "", "test") or die("Connessione fallita: " . mysqli_error($conn));

    $_email = mysqli_real_escape_string($conn, $_GET["email"]);

    $query = "SELECT email FROM users WHERE email = '$_email'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    mysqli_close($conn);

?>