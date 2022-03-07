<?php

    // 重置基本信息
    session_start();
    
    require_once("../functions.php");
    
    force_login("/controller/reset_basic.php");
    
    $reset = force_post_param("reset");
    
    if($reset == 1){
       $config = require("../config.php");
       $conf_base = require("../conf_base.php");
       
       $config = arr2_merge($conf_base,$config);
       
       save_config("../config.php");
       
       echo '{"errno":0,"msg":"success"}';
    }
    
?>