<?php

    //Prendo il nome e il token dalla richiesta GET
    $client_id = "2g9gv8obyn06srcxntpcgkf0gi8ovc";
    if(isset($_GET["q"]))
        $gameName = ($_GET["q"]);
    if(isset($_GET["gameId"]))
        $gameId = ($_GET["gameId"]);
        
    $token = ($_GET["token"]);

    //Richiesta per ottenere l'id del gioco e altri dati
    $ch = curl_init();
    if(isset($gameName))
        curl_setopt($ch, CURLOPT_URL, "https://api.igdb.com/v4/games/?search=" . urlencode($gameName) . "&fields=name,cover,summary&limit=30");
    else if(isset($gameId))
        curl_setopt($ch, CURLOPT_URL, "https://api.igdb.com/v4/games/" . $gameId . "?fields=name,cover,summary");
    $headers = array("Client-ID: ".$client_id, "Authorization: Bearer ".$token, "Accept: application/json");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $results = curl_exec($ch);
    curl_close($ch);
    echo $results;
    
?>