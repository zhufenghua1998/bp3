<?php

/**
 * 使用方式：传递refresh_token参数即可返回刷新数据
 */


// 1.获取参数

$refresh_token = $_GET['refresh_token'];

if(empty($refresh_token)){
    echo '{"error":"empty refresh_token"}';
    die;
}

// 获取配置文件
require_once("../config.php");
require_once("../functions.php");

    $app_id = $config['connect']['app_id'];
    $secret = $config['connect']['secret_key'];
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=refresh_token&refresh_token=$refresh_token&client_id=$app_id&client_secret=$secret";
    
    echo @file_get_contents($url);
    
    if(!strstr($http_response_header[0],"200")){
        echo '{"error":"invalid refresh_token"}';
    }

?>