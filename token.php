<?php
    //Pagina PHP per ottenere il token di accesso della API di Twitch

    $client_id = "2g9gv8obyn06srcxntpcgkf0gi8ovc";
    $client_secret = "ony793dwf62ci5ljeykq2tr1y69sxo";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,"https://id.twitch.tv/oauth2/token");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array(
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "grant_type" => "client_credentials"
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    
    echo $result;
    
?>