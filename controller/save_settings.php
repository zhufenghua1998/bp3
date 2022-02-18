<?php

    /*  保存用户修改的设置  */
    session_start();
    require_once("../functions.php");
    $config = require("../config.php");
    
    force_login();
    

    
    $config['site']['title'] = $_POST['s1'];
    $config['site']['subtitle'] = $_POST['s2'];
    $config['user']['name'] = $_POST['s3'];
    $config['user']['pwd'] = $_POST['s4'];
    $config['user']['lock'] = $_POST['s5'];
    $config['connect']['app_id'] = $_POST['s6'];
    $config['connect']['secret_key'] = $_POST['s7'];
    $config['connect']['redirect_uri'] = $_POST['s8'];
    $config['control']['pre_dir'] = $_POST['s9'];
    $config['site']['blog'] = $_POST['s10'];
    $config['site']['github'] = $_POST['s11'];
    $config['baidu']['baidu_account'] = $_POST['s12'];
    $config['baidu']['baidu_pwd'] = $_POST['s13'];
    $config['control']['pre_link'] = $_POST['s14'];
    $config['control']['close_dload'] = $_POST['s15'];
    $config['control']['open_grant'] = $_POST['s16'];
    $config['identify']['grant_url'] = $_POST['s17'];
    
    
    save_config("../config.php");
    
    echo '{"errno": 0, "errmsg": "success"}';
?>