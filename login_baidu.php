<?php
/**
 *  百度登录
 */
    require_once("./functions.php");
    
    // 取得传递的授权身份信息
    $param = force_get_param("param"); 

    $identify = json_decode($param,true);

    $access_token = $identify['access_token'];

    // 取得该身份的basic信息

    $basic = m_basic($access_token);

    // 再次校验是否已经配置百度登录
    
    if(empty($config) || empty($config['identify'] || empty($config['account']) || empty($config['account']['uk']))){
        
        echo '{"msg":"your identify is invalid","msg_CN":"管理员未配置百度登录，本次为非法请求"}';
        die;
    }
    
    // 比较用户id
    if($config['account']['uk'] == $basic['uk']){
        // 登录成功
        $_SESSION[$user] = $basic['baidu_name'];
        
        // 判断是否需要重置
        if($lock != $chance){
            $config['user']['chance']=$lock;
            save_config();
        }
        
        // 重定向
        redirect($login_url);
        
    }else{
        // 登录失败
        js_alert("非法用户，请使用账户：'$a_baidu_name'");

        js_location($login_url);
    }
