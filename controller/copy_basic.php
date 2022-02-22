<?php

    session_start();
    require_once("../functions.php");
    
    $config = require("../config.php");
    
    force_login();
    
    $copy = force_post_param("copy");

    if($copy=="1"){
        
        $basic = $config['basic'];
        
        $account = $basic;
        
        $config['account'] = $account;
        
        save_config("../config.php");
        
        echo '{"errno":0,"errmsg":"success"}';
    }else{
        echo '{"errno":1,"errmsg":"error"}';
    }
?>