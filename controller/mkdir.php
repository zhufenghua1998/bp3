<?php

    // 创建文件夹
    require_once('../functions.php');
    
    force_login();

    // 获取name参数
    $name = force_post_param("name");
    
    // 获取path参数
    $path = force_post_param("path");
    
    // 处理和拼接name和path，生成uri    
    $name = urlencode($name);
    
    if($path!="%2F"){
        $path = $path."%2F";
    }

    $uri = $path.$name;

    // 预上传
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=precreate&access_token=$access_token";
    $opts = array(
        'http' => array(
            'method' => 'POST', 
            'header' => 'User-Agent: pan.baidu.com',
            'content' => 'path='.$uri.'&size=0&isdir=1&autoinit=1&rtype=1&block_list=[""]'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);

    err_msg_file_get_content($opts);
    // echo $result;
    $precreate = json_decode($result);
    $uploadid = $precreate->uploadid;
    
    // 创建文件
    $url1 = "http://pan.baidu.com/rest/2.0/xpan/file?method=create&access_token=$access_token";
    $opts1 = array(
        'http' => array(
            'method' => 'POST', 
            'header' => 'User-Agent: pan.baidu.com',
            'content' => 'path='.$uri.'&size=0&isdir=1&autoinit=1&rtype=1'
            ));
    $context1 = stream_context_create($opts1);
    echo @file_get_contents($url1, false, $context1);

    err_msg_file_get_content($opts1);
?>