<?php
    $client_id = "2g9gv8obyn06srcxntpcgkf0gi8ovc";
    $id = $_GET["q"];
    $token = $_GET["token"];

    //Crea la richiesta curl per ottenere le copertine dei diversi giochi precedentemente ottenuti
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.igdb.com/v4/covers/");
    $headers = array("Client-ID: ".$client_id, "Authorization: Bearer ".$token, "Accept: application/json");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "fields url; where id = " . $id . ";");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $results = curl_exec($ch);
    curl_close($ch);

    echo $results;
?>