<?php

    // 删除文件功能，不可直接访问，必须登录
    session_start();
    if(empty($_SESSION['user'])){
        echo '{"error":"user not login"}';
        die;
    }
    // 获取path（不需要urlencode，如果有urlencode会自动解码）
    $path =  $_GET['path'];
    $path = urldecode($path);
    if(empty($path)){
        echo '{"error":"path is empty"}';
        die;
    }
    // 尝试删除
    require_once('../config.php');
    require_once('../functions.php');
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=filemanager&access_token=$access_token&opera=delete";
    $opts = array(
        'http' => array(
            'method' => 'POST', 
            'header' => 'User-Agent: pan.baidu.com',
            'content' => 'async=0&filelist=["'.$path.'"]'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    echo $result;
?>