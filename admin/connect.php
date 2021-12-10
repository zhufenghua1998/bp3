<?php
    session_start();
    $config_file = "../config.php";
    require_once($config_file);
    require_once("../functions.php");
    if(empty($_SESSION['user'])){
        echo '{"error":"user not login"}';
        die;
    }
    $identify = $_GET['param'];
    // 如果不存在param参数
    if(empty($identify)){
        echo '{"error":"not param"}';
        die;
    }
    // 填写identify信息
    $identify = urldecode($identify);
    $json = json_decode($identify,true);
    $json['conn_time'] = time();
    $config['identify'] = $json;
    $text='<?php $config='.var_export($config,true).';'; 
    file_put_contents($config_file,$text);

    // 获取basic
    require('./basic.php');
    // 返回首页
    $dirUrl =getDirUrl(basename(__FILE__));
    header("Location: $dirUrl");
?>
    
    
    