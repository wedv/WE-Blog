<?php

function get_contents($url){
    /*
    if (ini_get("allow_url_fopen") == "1") {
        $response = file_get_contents($url);
    }else{
    */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FAILONERROR, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response =  curl_exec($ch);
    curl_close($ch);
    //}
    return $response;
}

echo get_contents($_GET['url']);