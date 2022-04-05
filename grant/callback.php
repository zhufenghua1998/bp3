<?php
    require_once("../functions.php");

    // 1.获取state
    $state = $_SESSION['state'];
    if($state!=$_GET['state']){
        echo '{"error":"invalid state"}';
        die;
    }
    // 2.获取基础连接信息
    
    $code = $_GET['code'];
    $app_key = $config['connect']['app_id'];
    $secret_key = $config['connect']['secret_key'];
    $redirect_uri = $config['connect']['redirect_uri'];
    
    // 3.callback请求

    $identify = m_callback($code,$app_key,$secret_key,$redirect_uri,$state,$grant,$grant_refresh);

    // 4.结果处理，存入session并重定向
    $_SESSION['grant_result'] = $identify;

    if($_SESSION['display']=='display'){
        redirect("display.php");
    }else{
        $display = urldecode($_SESSION['display']); // 重定向地址
        $str_identify = json_encode($identify);
        $encode_result = urlencode($str_identify); // 字符串转码
        // 重定向并携带参数
        $redirect_with_param = $display.'?param='.$encode_result;
        redirect($redirect_with_param);
    }

    
    