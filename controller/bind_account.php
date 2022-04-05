<?php

    require_once("../functions.php");
    
    force_login();
    
    $param = force_get_param("param"); 

    $obj = json_decode($param);
    
    $access_token = $obj->access_token;
    
    $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$access_token&method=uinfo";
    
    $result = easy_file_get_content($url);
    
    $arr = json_decode($result,true);
    
    $config['account'] = $arr;
    
    save_config();
    
    js_location("../admin/index.php");
