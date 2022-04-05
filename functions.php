<?php
    // 开启session
    session_start();

    /* ------------------ 1.环境检测、引入基本函数等、其他内容等 ----------------------- */

    //定义主配置文件路径
    $config_path = "/config.php";

    //安装前允许访问的路径
    $install_paths = ["/install.php","/install_fast.php","/install_inner.php","/install_config.php"];

    // 引入基本函数
    require_once("inc/fun_core.php");

    // 安装检测
    $install = check_install($config_path,$install_paths);

    // 引入http函数
    require_once("inc/fun_http.php");

    // 引入curl模块
    $check_curl = is_callable("curl_init");
    if($check_curl){
        // 暂无需curl
    }else{
        
    }

    // 引入百度业务函数
    require_once("inc/fun_baidu.php");

    // 引入zip扩展类
    $check_zip = class_exists("ZipArchive");
    if($check_zip){
        require_once("inc/zip.class.php");
    }else{
        echo "<p>警告：当前环境不存在zip扩展</p>";
    }

    /* -------------------- 2.程序需要定义一些全局变量为基本配置 ---------------------- */

    // 网站根目录url
    $site_url = get_site_url();

    // 程序根目录
    $base_url = get_base_url();

    // 目录url
    $dir_url = get_dir_url();

    // 页面url
    $page_url = get_page_url();

    // 页面转码url
    $enc_page_url = urlencode($page_url);

    // 定义登录管理员使用的session
    $user = "user";

    // 登录地址url
    $login_url = get_file_url("/login.php");

    // 后台地址
    $admin_url = get_file_url("/admin/");

    // 取得后台connect地址
    $connect_url = get_file_url('/admin/connect.php');

    //获取刷新接口地址（程序中一般不用，开放给外部定时器调用）
    $refresh_url = get_file_url("/admin/refresh_token.php");

    //获取开放token地址（程序中一般不调用，开放给外部调用）
    $open_url = get_file_url("/open.php");

    // 下载地址
    $dn_url = get_file_url("/dn.php");

    // 后台直链地址
    $dlink_url = get_file_url("/admin/dlink.php");

    //免app授权地址
    $grant = get_file_url("/grant/");

    //内置app授权地址
    $grant2 = get_file_url("/grant2/");

    //免app授权系统刷新地址
    $grant_refresh = get_file_url("/grant/refresh.php");

    //内置app授权系统刷新地址
    $grant2_refresh = get_file_url("/grant2/refresh.php");

    //当前时间
    $time = time();

    //服务器IP
    $server_ip = get_server_ip();

    //客户端IP
    $remote_ip = get_remote_ip();

    //是否已登录？
    $check_login = check_session();

    /*  --------------------------  3.主配置信息  -------------------------*/

    //取得基础配置文件
    $base = get_config("/conf_base.php");

    //配置信息
    $config = get_config();

    //版本
    $version = isset($config['version'])? $config['version'] : $base['version'];

    //用户信息
    $lock   = isset($config['user'])? $config['user']['lock']   : $base['user']['lock'];
    $chance = isset($config['user'])? $config['user']['chance'] : $base['user']['chance'];
    $name   = isset($config['user'])? $config['user']['name']   : $base['user']['name'];
    $pwd    = isset($config['user'])? $config['user']['pwd']    : $base['user']['pwd'];
    //站点信息
    $title          = isset($config['site'])? $config['site']['title']      : $base['site']['title'];
    $subtitle       = isset($config['site'])? $config['site']['subtitle']   : $base['site']['subtitle'];
    $blog           = isset($config['site'])? $config['site']['blog']       : $base['site']['blog'];
    $github         = isset($config['site'])? $config['site']['github']     : $base['site']['github'];
    $description    = isset($config['site'])? $config['site']['description']: $base['site']['description'];
    $keywords       = isset($config['site'])? $config['site']['keywords']   : $base['site']['keywords'];
    //权限控制信息
    $pre_dir        = isset($config['control'])? $config['control']['pre_dir']     : $base['control']['pre_dir'];
    $close_dlink    = isset($config['control'])? $config['control']['close_dlink'] : $base['control']['close_dlink'];
    $close_dload    = isset($config['control'])? $config['control']['close_dload'] : $base['control']['close_dload'];
    $open_grant     = isset($config['control'])? $config['control']['open_grant']  : $base['control']['open_grant'];
    $open_grant2    = isset($config['control'])? $config['control']['open_grant2'] : $base['control']['open_grant2'];
    $open_session   = isset($config['control'])? $config['control']['open_session']: $base['control']['open_session'];
    $grant_type     = isset($config['control'])? $config['control']['grant_type']  : $base['control']['grant_type'];
    $update_type    = isset($config['control'])? $config['control']['update_type'] : $base['control']['update_type'];
    $update_url     = isset($config['control'])? $config['control']['update_url']  : $base['control']['update_url'];
    $dn_limit       = isset($config['control'])? $config['control']['dn_limit']    : $base['control']['dn_limit'];
    $dn_speed       = isset($config['control'])? $config['control']['dn_speed']    : $base['control']['dn_speed'];

    //内置信息, inner
    $inner_app_key      = isset($config['inner'])? $config['inner']['app_id']       : $base['inner']['app_id'];
    $inner_secret_key   = isset($config['inner'])? $config['inner']['secret_key']   : $base['inner']['secret_key'];
    $inner_redirect_uri = isset($config['inner'])? $config['inner']['redirect_uri'] : $base['inner']['redirect_uri'];

    //免app信息，connect
    $app_key        = isset($config['connect'])? $config['connect']['app_id'] : "";
    $secret_key     = isset($config['connect'])? $config['connect']['secret_key'] : "";
    $redirect_uri   = isset($config['connect'])? $config['connect']['redirect_uri'] : "";

    //身份信息identify
    $access_token       = m_token_refresh(); // 同时自动检测有效期
    $expires_in         = isset($config['identify'])? $config['identify']['expires_in'] : 0;
    $refresh_token      = isset($config['identify'])? $config['identify']['refresh_token'] : "";
    $session_secret     = isset($config['identify'])? $config['identify']['session_secret'] : "";
    $session_key        = isset($config['identify'])? $config['identify']['session_key'] : "";
    $scope              = isset($config['identify'])? $config['identify']['scope'] : "";
    $grant_url          = isset($config['identify'])? $config['identify']['grant_url'] : "";
    $refresh_url        = isset($config['identify'])? $config['identify']['refresh_url'] : "";
    $conn_time          = isset($config['identify'])? $config['identify']['conn_time'] : 0;

    //basic，连接基础信息
    $baidu_name   = isset($config['basic'])? $config['basic']['baidu_name']:"";
    $netdisk_name = isset($config['basic'])? $config['basic']['netdisk_name']:"";
    $uk           = isset($config['basic'])? $config['basic']['uk']:  -1;
    $vip_type     = isset($config['basic'])? $config['basic']['vip_type']: -1;

    //绑定的百度信息，account
    $a_baidu_name   = isset($config['account'])? $config['account']['baidu_name']:"";
    $a_netdisk_name = isset($config['account'])? $config['account']['netdisk_name']:"";
    $a_uk           = isset($config['account'])? $config['account']['uk']:  -1;
    $a_vip_type     = isset($config['account'])? $config['account']['vip_type']: -1;

    //自定义存储百度信息，baidu
    $baidu_account      = isset($config['baidu'])? $config['baidu']['baidu_account']:  "";
    $baidu_pwd          = isset($config['baidu'])? $config['baidu']['baidu_pwd']: "";

    /* -------------------  4.常用业务处理  --------------------*/
    // 编码后的connect地址
    $enc_connect_url = urlencode($connect_url);
    // 后台连接授权地址
    $connect_grant_url      = "$grant_url?display=$enc_connect_url";
    // 编码后的绑定百度登录地址
    $enc_bind_account_url   = urlencode(get_file_url("/controller/bind_account.php"));
    // 快速绑定百度登录授权地址
    $bind_account_grant_url = "$grant_url?display=$enc_bind_account_url";



