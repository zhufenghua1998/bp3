<?php

    // 重置基本信息
    require_once("../functions.php");
    
    force_login();
    
    $reset = force_post_param("reset");
    
    if($reset == 1){

       $config = arr2_merge($base,$config);
       
       save_config();
       
       echo '{"errno":0,"msg":"success"}';
    }
