<?php
    // 图片列表展示
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    
    force_login();
    
    $path = force_get_param("path");
    
    $path = urldecode($path);
    // 一次至多查找$num张
    $num = 1000;
    $encode_path = urlencode($path);
    
    $access_token = $config['identify']['access_token'];
    
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?parent_path=$encode_path&access_token=$access_token&web=1&recursion=1&method=imagelist&num=$num";
    
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'USER-AGENT: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);

    errmsg_file_get_content();
    
    $json = json_decode($result);
    $realNum = count($json->info);
    echo "<h2>正在尝试获取该目录下的所有图片，本次最多提取 $num 张，本次取到：$realNum 张，仅显示png和jpg格式：</h2>";
    foreach ($json->info as $info){
        $fileName = $info->server_filename;
        $file_end = substr($fileName, strrpos($fileName, '.')+1);
        if($file_end=="png"||$file_end=="PNG"||$file_end=="jpg"||$file_end=="JPG"||$file_end=="jpeg"||$file_end=="JPEG"){
            $src = $info->thumbs->url3;
            echo "<img src='$src'/>";
        }
    }
    

?>