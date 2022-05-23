<?php
    require_once("./functions.php");
    
    // 本机IP，或用户已登录，返回access_token
    if($remote_ip == $server_ip || $check_login){

        echo $access_token;
    }

