<?php
    require_once("../functions.php");
    
    
    // 1.获取state
    $state = force_get_param("state");
    $s_state = force_session_param("state");
    // 校验state，防止csrf攻击
    if($state!=$s_state){
        build_err("state无效");
    }
    // 2.获取基础连接信息
    
    $code = $_GET['code'];
    $app_id = $config['inner']['app_id'];
    $secrect_key = $config['inner']['secret_key'];
    $redirect_uri = $config['inner']['redirect_uri'];
    
    // 3.callback请求
    $identify = m_callback($code,$app_id,$secrect_key,$redirect_uri,$state,$grant2,$grant2_refresh);

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
