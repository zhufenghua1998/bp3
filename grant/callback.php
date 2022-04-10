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
    $code = force_get_param("code");

    // 检测系统初始化
    if(empty($app_key)){
        build_err("系统还未初始化");
    }
    // 3.callback请求

    $identify = m_callback($code,$app_key,$secret_key,$redirect_uri,$state,$grant,$grant_refresh);

    // 4.结果处理，存入session并重定向，使用arr数据类型
    $_SESSION['grant_result'] = $identify;

    if($_SESSION['display']=='display'){
        redirect("display.php");
    }else{
        $display = urldecode($_SESSION['display']); // 取得重定向地址
        $str_identify = json_encode($identify);
        $encode_result = urlencode($str_identify); // 字符串转码得到参数
        // 重定向并携带参数
        $redirect_with_param = $display.'?param='.$encode_result;
        redirect($redirect_with_param);
    }

    
    