<?php

    $url = "https://api.github.com/repos/zhufenghua1998/bp3/releases/latest";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT,"zhufenghua1998");
    
    curl_exec($ch); 
    
?>