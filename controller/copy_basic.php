<?php

    require_once("../functions.php");

    force_login();
    
    $copy = force_post_param("copy");

    if($copy=="1"){
        
        $basic = $config['basic'];
        
        $account = $basic;
        
        $config['account'] = $account;
        
        save_config();
        
        build_success();
    }else{
        build_err("参数错误");
    }
