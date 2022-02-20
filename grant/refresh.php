<?php

/**
 * 使用方式：传递refresh_token参数即可返回刷新数据
 */
 
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");


    // 1.获取参数
    $refresh_token = force_get_param('refresh_token');

    $app_id = $config['connect']['app_id'];
    $secret = $config['connect']['secret_key'];
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=refresh_token&refresh_token=$refresh_token&client_id=$app_id&client_secret=$secret";
    
    echo @file_get_contents($url);

    errmsg_file_get_content();
?>