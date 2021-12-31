<?php
    session_start();
    require_once("../config.php");
    if(!$_SESSION['user']){
        echo "请登录";
        die;
    }
    $path = $_GET['path'];
    if(empty($path)){
        echo "请输入视频的path路径";
        die;
    }
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
    if(!strstr($http_response_header[0],"200")){
        echo '{"error":"your path is invalid"}';
        die;
    }
    
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