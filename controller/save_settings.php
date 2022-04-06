<?php

    /*  保存用户修改的设置  */
    require_once("../functions.php");

    force_login();

    $check = true;
    
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
    $config['control']['close_dlink'] = $_POST['s14'];
    $config['control']['close_dload'] = $_POST['s15'];
    $config['control']['open_grant'] = $_POST['s16'];
    $config['identify']['grant_url'] = $_POST['s17'];
    $config['control']['grant_type'] = $_POST['s17s'];
    $config['control']['open_grant2'] = $_POST['s18'];
    $config['control']['open_session'] = $_POST['s19'];
    $config['site']['description'] = $_POST['s20'];
    $config['site']['keywords'] = $_POST['s21'];
    $config['inner']['app_id'] = $_POST['s22'];
    $config['inner']['secret_key'] = $_POST['s23'];
    $config['control']['update_type'] = $_POST['s24'];
    $config['control']['update_url'] = $_POST['s24u'];
    // $config['control']['dn_limit'] = $_POST['s25'];
    // $config['control']['dn_speed'] = $_POST['s26'];
    // if(!is_numeric($_POST['s26'])){
    //     $check = false;
    // }

    if($check){
        save_config("../config.php");
        echo '{"errno": 0, "errmsg": "success"}';
    }else{
        echo '{"errno": -1, "errmsg": "请填写正确的数据格式"}';
    }

