<?php
    session_start();
/**
 *  文件下载模块，访客权限可用
 */
    // 1.获取fsid
    $fsid =  $_GET['fsid'];
    if(empty($fsid)){
        echo '无效fsid';
        die;
    }
    require_once('./config.php');
    // 2.查询下载链接
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=$access_token&method=filemetas&fsids=[$fsid]&dlink=1&thumb=1&dlink=1&extra=1";
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'User-Agent: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    $json = json_decode($result);
    $dlink =  $json->list[0]->dlink;
    $file_size = $json->list[0]->size;
    $file_name = $json->list[0]->filename;
    
    // 3.下载文件
      //get请求参数
    $request_data = array('access_token' => $access_token);
    //初始化curl对象
    $ch = curl_init();
    //设置URL
    curl_setopt($ch, CURLOPT_URL, $dlink);
    // 直接返回给浏览器
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    // 设置access_token
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
    // 设置user-agent
    curl_setopt($ch, CURLOPT_USERAGENT,"pan.baidu.com");
    // 允许301,302
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // 取消https验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);


    // 返回header给浏览器，并执行curl
    header("Content-type: application/octet-stream"); 
    header("Accept-Ranges: bytes"); 
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: $file_size");
    header('Content-Transfer-Encoding: binary');
    curl_exec($ch);  

    

    
    
?>