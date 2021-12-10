<?php
    session_start();
    // 1.获取state
    $state = $_SESSION['state'];
    if($state!=$_GET['state']){
        echo '{"error":"invalid state"}';
        die;
    }
    // 2.获取基础连接信息
    require_once("../config.php");
    require_once("../functions.php");
    
    $code = $_GET['code'];
    $app_id = $config['connect']['app_id'];
    $secrect_key = $config['connect']['secret_key'];
    $redirect_uri = $config['connect']['redirect_uri'];
    // 3.callback请求
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$app_id&client_secret=$secrect_key&redirect_uri=$redirect_uri&state=$state";
    $result = @file_get_contents($url, false);
    if(!strstr($http_response_header[0],"200")){
        echo '{"error":"invalid refresh_token"}';
        die;
    }
    
    // 4.结果处理，存入session并重定向
    // 动态增加授权地址grant_url和刷新地址refresh_url
    $grant_url = getDirUrl(basename(__FILE__));
    $refresh_url = $grant_url.'refresh.php';
    
    $json = json_decode($result);
    $json->grant_url=$grant_url;
    $json->refresh_url=$refresh_url;
    $result = json_encode($json);
    
    $_SESSION['result'] = $result;
    if($_SESSION['display']=='display'){
        header("Location: ./display.php");
    }else{
        $display = urldecode($_SESSION['display']);
        $encode_result = urlencode($result);
        // 重定向并携带参数
        $redirect_param = $display.'?param='.$encode_result;
        header("Location: $redirect_param");
    }
?>
    
    
    