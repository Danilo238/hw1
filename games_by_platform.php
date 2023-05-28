<?php
    $clientId = "2g9gv8obyn06srcxntpcgkf0gi8ovc";
    $platform = $_GET["platform"];
    $token = $_GET["token"];

    $url = "https://api.igdb.com/v4/platforms?search=".$platform.";";
    $headers = array("Client-ID: ".$clientId, "Authorization: Bearer ".$token, "Accept: application/json");

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl);
    $result = json_decode($result, true);
    $platformId = $result[0]["id"];
    curl_close($curl);

    $data = 'fields name,cover,rating,platforms,summary; where platforms = '.$platformId.' & rating <= 100; sort rating desc; limit 30;';
    $curl = curl_init();
    $url = "https://api.igdb.com/v4/games/";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $res = curl_exec($curl);
    curl_close($curl);

    echo $res;
?>