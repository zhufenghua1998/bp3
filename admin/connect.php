<?php
    require_once("../functions.php");
    
    force_login();  // 强制登录
    
    $identify = force_get_param("param");

    $str_identify = urldecode($identify);
    // 取得identify信息

    $config['identify'] =  json_decode($str_identify,true);
    
    save_config();

    // 获取basic
    $basic = m_basic($config['identify']['access_token']);
    
    $config['basic'] = $basic;
    
    // 保存config
    save_config();

    //返回首页
    redirect($dir_url);

    
    