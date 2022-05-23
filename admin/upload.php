<?php
    // 不可直接访问，必须登录
    require_once('../functions.php');
    
    force_login();
    
    // 预上传
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
        err_msg_file_get_content($opts);
        if(isset($result)){
            $json_obj = json_decode($result);
            $json_obj->access_token = $access_token;
            $result = json_encode($json_obj);
        }
        echo $result;
    }else if($method=="upload"){
        
        $fastUrl = $_POST['fastUrl'];

        $temp_dir = get_base_root().DIRECTORY_SEPARATOR."temp";
        if (!file_exists($temp_dir)) {
            mkdir($temp_dir);
        }
        $temp_name = $_FILES["file"]["name"];
        $temp_uri =  $temp_dir.DIRECTORY_SEPARATOR.$temp_name;
        move_uploaded_file($_FILES["file"]["tmp_name"], $temp_uri);
        
        $file = file_get_contents($temp_uri);  // 注意要用 rb 形式读取，file_get_contents会失败
        
        $url = $fastUrl;

        $result =  easy_file_get_content($url,easy_build_opt("POST","file=".$file.""));
        $a = 1;
        echo $result;
//        unlink($temp_uri);

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
        err_msg_file_get_content($opts);
        echo $result;
    }
