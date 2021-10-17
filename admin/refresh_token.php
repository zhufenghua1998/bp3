<?php
    // 刷新token
    $config_file = "../config.php";
    require_once($config_file);
    
    $refresh_token = $config['identify']['refresh_token'];
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
    
    //是否自动返回
    $back_url = $_GET['redirect'];
    if(!$back_url){  // 无需重定向
        echo "刷新token成功";
        die;  
    }
    $back_url = urldecode($back_url);
?>
<h2>token刷新成功，即将自动返回...</h2>
<script>
   setTimeout(function () {
        window.location.href = "<?php echo $back_url;?>";
   }, 1500); 
 
</script>