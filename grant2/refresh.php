<?php

/**
 * 使用方式：传递refresh_token参数即可返回刷新数据
 */
    require_once("../functions.php");

    // 1.获取参数
    $refresh_token = force_get_param('refresh_token');

    $app_id = $config['inner']['app_id'];
    $secret = $config['inner']['secret_key'];
    // 获取刷新后的信息
    $identify = m_refresh($refresh_token,$app_id,$secret,$grant2,$grant2_refresh);
    // 输出
    echo $identify;
