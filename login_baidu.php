<?php

    session_start();
    
    require_once("./functions.php");
    
    $config = require("./config.php");
    
    // 取得授权身份信息
    $param = force_get_param("param"); 

    $obj = json_decode($param);
    
    $access_token = $obj->access_token;
    
    $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$access_token&method=uinfo";
    
    $opt = easy_build_http("GET");
    
    // 取得basic信息
    $result = easy_file_get_content($url,$opt);
    
    $arr = json_decode($result,true);
    
    
    // 再次校验是否已经配置百度登录
    
    if(empty($config) || empty($config['identify'] || empty($config['account']) || empty($config['account']['uk']))){
        
        echo '{"errmsg":"your identify is invalid","msg_CN":"非法请求"}';
        die;
    }
    
    // 比较用户id
    if($config['account']['uk'] == $arr['uk']){
        // 登录成功
        $_SESSION['user'] = $arr['baidu_name'];
        
        // 解锁普通用户
        $lock = $config['user']['lock'];
        // 判断是否需要重置
        if($lock != $config['user']['chance']){
            $config['user']['chance']=$lock;
            save_config("./config.php");
        }
        
        // 重定向
        easy_location("./login.php");
        
    }else{
        // 登录失败
        echo '<script>alert("非法用户，请使用账户：'.$config['account']['baidu_name'].'")</script>';
        
        easy_location("./login.php");
    }
    
?>