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
    require('./basic.php');
    // 返回首页
    $dirUrl =getDirUrl(basename(__FILE__));
    header("Location: $dirUrl");
?>
    
    
    