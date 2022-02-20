<?php

    // 删除文件功能
    session_start();
    $config = require('../config.php');
    require_once('../functions.php');
    
    force_login();  // 强制登录
    
    // 获取path
    $path = force_get_param("path");
    //（不需要urlencode，如果有urlencode会自动解码）
    $path = urldecode($path);
    
    
    // 尝试删除
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=filemanager&access_token=$access_token&opera=delete";
    $opts = array(
        'http' => array(
            'method' => 'POST', 
            'header' => 'User-Agent: pan.baidu.com',
            'content' => 'async=0&filelist=["'.$path.'"]'
            ));
    $context = stream_context_create($opts);
    echo @file_get_contents($url, false, $context);
    
    errmsg_file_get_content($opts);
    
?>