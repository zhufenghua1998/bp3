<?php
    session_start();
    // 1.获取state
    $state = $_SESSION['state'];
    if($state!=$_GET['state']){
        echo "非法state";
        die;
    }
    // 2.获取基础连接信息
    require_once("./config.php");
    require_once("./functions.php");
    
    $code = $_GET['code'];
    $app_id = $connect['app_id'];
    $secrect_key = $connect['secret_key'];
    $redirect_uri = $connect['redirect_uri'];
    // 3.callback请求
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$app_id&client_secret=$secrect_key&redirect_uri=$redirect_uri&state=$state";
    $result = file_get_contents($url, false);
    // 4.结果处理，存入session并重定向
    $_SESSION['result'] = $result;
    header("Location: ./display.php");
?>
    
    
    