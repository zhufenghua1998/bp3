<?php
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    
    force_login("/admin/connect.php");  // 强制登录
    
    $identify = force_get_param("param");
    
    // 取得identify信息
    $identify = urldecode($identify);
    
    $arr = json_decode($identify,true);
    $arr['conn_time'] = time();
    $config['identify'] = $arr;
    
    save_config("../config.php");

    // 获取basic
    get_m_basic();
    
    // 保存config
    save_config("../config.php");

    //返回首页
    $dirUrl =get_dir_url(basename(__FILE__));
    header("Location: $dirUrl");
?>
    
    
    