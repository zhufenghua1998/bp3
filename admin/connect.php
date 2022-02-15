<?php
    session_start();
    require("../config.php");
    require_once("../functions.php");
    
    force_login();  // 强制登录
    
    $identify = force_get_param("param");
    
    // 填写identify信息
    $identify = urldecode($identify);
    
    $arr = json_decode($identify,true);
    $arr['conn_time'] = time();
    $config['identify'] = $arr;
    
    save_config("../config.php");

    // 获取basic
    $token = $config['identify']['access_token'];
    $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
    $result = @file_get_contents($url);
    
    errmsg_file_get_content();
    
    $arr = json_decode($result,true);
    
    $config['basic'] = $arr;
    
    save_config("../config.php");

    // 获取basic
    header("Location: ./index.php");
?>
    
    
    