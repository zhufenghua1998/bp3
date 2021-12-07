<?php
    // 刷新token
    $config_file = "../config.php";
    require_once($config_file);
    
    $refresh_token = $config['identify']['refresh_token'];
    $refresh_url = $config['identify']['refresh_url'];
    
    if(isset($refresh_url)){
        // 免app刷新
        
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
        $text='<?php $config='.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
    }else{
        
        // 内置app刷新
        $app_id = $config['connect']['app_id'];
        $secret = $config['connect']['secret_key'];
        
        $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=refresh_token&refresh_token=$refresh_token&client_id=$app_id&client_secret=$secret";
        $result = file_get_contents($url,false);
        $json = json_decode($result);
        $config['identify']['expires_in'] = $json->expires_in;
        $config['identify']['conn_time'] = time();
        $config['identify']['refresh_token'] = $json->refresh_token;
        $config['identify']['access_token'] = $json->access_token;
        $config['identify']['scope'] = $json->scope;
        $text='<?php $config='.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
    }

?>
