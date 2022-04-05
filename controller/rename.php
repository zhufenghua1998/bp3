<?php

    // 文件重命名功能
    require_once('../functions.php');

    force_login();  // 强制登录
    // 获取path
    $path = force_get_param("path");
    //（不需要urlencode，如果有urlencode会自动解码）
    $path = urldecode($path);
    // 获取name
    $name = force_get_param("name");
    $name =urldecode($name);
    
    // 尝试重命名
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=filemanager&access_token=$access_token&opera=rename";
    $opts = array(
        'http' => array(
            'method' => 'POST', 
            'header' => 'User-Agent: pan.baidu.com',
            'content' => 'async=0&filelist=[{"path":"'.$path.'","newname":"'.$name.'"}]'
            ));
    $context = stream_context_create($opts);
    echo @file_get_contents($url, false, $context);

    err_msg_file_get_content($opts);
?>