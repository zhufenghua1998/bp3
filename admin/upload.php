<?php
    // 不可直接访问，必须登录
    session_start();
    $config = require('../config.php');
    require_once('../functions.php');
    
    if(empty($_SESSION['user'])){
        echo '{"error":"user not login"}';
        die;
    }
    
    $log = "";  // 日志
    $log_file = "./upload_php_log.txt";
    
    // 预上传

    
    $access_token = $config['identify']['access_token'];
    
    $method = $_GET['method'];
    
    $path = $_POST['path'];
    $path = urldecode($path);
    $path = urlencode($path);
    $size = $_POST['size'];
    $block_list = $_POST['block_list'];
    $myuploadid = $_POST['uploadid'];
    
    if($method=="precreate"){
        
        $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=precreate&access_token=$access_token";
        $opts = array(
            'http' => array(
                'method' => 'POST', 
                'header' => 'User-Agent: pan.baidu.com',
                'content' => 'path='.$path.'&size='.$size.'&isdir=0&autoinit=1&rtype=1&block_list='.$block_list
                ));
        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);
        if(isset($result)){
            $json_obj = json_decode($result);
            $json_obj->access_token = $access_token;
            $result = json_encode($json_obj);
        }
        echo $result;
    }else if($method=="upload"){
        
        $fastUrl = $_POST['fastUrl'];
        
        
        $temp_dir = "../temp";
        if (!file_exists($temp_dir)) {
            mkdir($temp_dir);
        }        
        $temp_name = date("Y-m-d H:i:s l");
        $temp_uri =  $temp_dir."/".$temp_name;
        move_uploaded_file($_FILES["file"]["tmp_name"],$temp_uri);
        
        $file = file_get_contents($temp_uri);
        
        $url = $fastUrl;
        
        file_put_contents($log_file,$url);
        
        //初始化curl对象
        $ch = curl_init();
        //设置URL
        curl_setopt($ch, CURLOPT_URL, $url);
        // 设置请求方式为post
        curl_setopt($ch,CURLOPT_POST,true);
        // 发送数据
        $payload = array(
            'file'=>$file,
            );
        curl_setopt($ch,CURLOPT_POSTFIELDS,$payload);
        curl_setopt($ch, CURLOPT_USERAGENT,"pan.baidu.com");
        //以流形式返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 取消https验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        
        //执行curl, 将返回md5
        echo curl_exec($ch);

    }else if($method=="create"){
        // 创建文件
        $url = "http://pan.baidu.com/rest/2.0/xpan/file?method=create&access_token=$access_token";
        $opts = array(
            'http' => array(
                'method' => 'POST', 
                'header' => 'User-Agent: pan.baidu.com',
                'content' => 'path='.$path.'&size='.$size.'&isdir=0&rtype=1&uploadid='.$myuploadid.'&block_list='.$block_list
                ));
        $context = stream_context_create($opts);
        $result = @file_get_contents($url, false, $context);
        echo $result;
    }

    // file_put_contents($log_file,$log);
?>