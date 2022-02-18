<?php
    // 刷新token
    $config = require('../config.php');
    require_once("../functions.php");
    
    $refresh_token = $config['identify']['refresh_token'];
    $refresh_url = $config['identify']['refresh_url'];
    
    // 自动根据授权时的信息刷新    
    $url = "$refresh_url?refresh_token=$refresh_token";
    $ch = curl_init();
    //设置URL
    curl_setopt($ch, CURLOPT_URL, $url);
    // 取消https验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // 以文件流形式返回数据，而不是直接输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $json = json_decode($result);
    $config['identify']['expires_in'] = $json->expires_in;
    $config['identify']['conn_time'] = time();
    $config['identify']['refresh_token'] = $json->refresh_token;
    $config['identify']['access_token'] = $json->access_token;
    $config['identify']['scope'] = $json->scope;
    save_config("../config.php");

?>
