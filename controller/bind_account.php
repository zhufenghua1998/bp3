<?php

    session_start();
    
    require_once("../functions.php");
    
    $config = require("../config.php");
    
    force_login("/controller/bind_account.php");
    
    $param = force_get_param("param"); 

    $obj = json_decode($param);
    
    $access_token = $obj->access_token;
    
    $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$access_token&method=uinfo";
    
    $opt = easy_build_http("GET");
    $result = easy_file_get_content($url,$opt);
    
    $arr = json_decode($result,true);
    
    $config['account'] = $arr;
    
    save_config("../config.php");
    
    easy_location("../admin/index.php");
?>