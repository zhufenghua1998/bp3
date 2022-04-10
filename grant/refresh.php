<?php

/**
 * 使用方式：传递refresh_token参数即可返回刷新数据
 */
    require_once("../functions.php");

    // 1.获取参数
    $refresh_token = force_get_param('refresh_token');

    if(!$app_key){
        $msg = array(
            'errno' => -1,
            'errmsg' => "此授权系统还未初始化"
        );
        build_err($msg);
    }

    // 获取刷新后的信息
    $identify = m_refresh($refresh_token,$app_key,$secret_key,$grant,$grant_refresh);

    // 输出
    echo $identify;


