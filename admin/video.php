<?php
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    
    force_login();
    
    $path = force_get_param("path");
    
    // 不使用js编码，使用php解码后重新编码
    $path = urldecode($path);
    $encode_path = urlencode($path);
    
    
    $access_token = $config['identify']['access_token'];
    
    $ts = "M3U8_AUTO_480";
    $flv = "M3U8_FLV_264_480";
    // 预使用类型
    $type = $ts;
    // 第一次请求
    $url = "https://pan.baidu.com/rest/2.0/xpan/file?method=streaming&access_token=$access_token&path=$encode_path&type=$type";
    
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'USER-AGENT: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    errmsg_file_get_content($opts);
    
    echo $result;
    // $json = json_decode($result);
    // $adToken = $json->adToken;
    // $adToken = urlencode($adToken);
    
    // // 第二次请求
    // sleep($json->ltime);
    // $url = "https://pan.baidu.com/rest/2.0/xpan/file?method=streaming&access_token=$access_token&path=$encode_path&type=$type&adToken=$adToken";
    
    // $opts = array(
    //     'http' => array(
    //         'method' => 'GET', 
    //         'header' => 'USER-AGENT: pan.baidu.com'
    //         ));
    // $context = stream_context_create($opts);
    // $result = @file_get_contents($url, false, $context);
    // if(!strstr($http_response_header[0],"200")){
    //     echo '{"error":"your path is invalid"}';
    //     die;
    // }
    // echo $result;
?>