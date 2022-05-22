<?php 
    require_once("./functions.php");
    
    // 已登陆，重定向
    if($check_login){
        redirect($admin_url);
    }
    // 校验是否配置百度登录
    $bind_baidu = false;
    if(isset($config) && isset($config['identify']) && isset($config['account'])){
        $bind_baidu = true;
    }
    $login_baidu_url = null;
    if($bind_baidu){

        $login_controller = urlencode("$base_url/login_baidu.php");

        $login_baidu_url = "$grant_url?display=$login_controller"; // 快速登录百度地址
    }

    $name = $_POST['user'];
    $pwd = $_POST['pwd'];

    // 用户密码为空，不处理
    if(!$name && !$pwd){
        // 表示未输入
    }
    else if($config['user']['name']==$name && $config['user']['pwd']==$pwd && $chance>0){
        // 登陆成功
        $_SESSION['user'] = $name;
        // 是否重置机会
        if($lock!=$chance){
            $config['user']['chance']=$lock;
            save_config();
        }
        redirect($admin_url);
    }else{
        // 次数减少
        $chance--;
        $config['user']['chance'] = $chance;
        save_config();
        if($chance<=0){
            js_alert('账户已经锁定！请ftp编辑或删除配置文件，或使用百度登录');
        }
        else{
            js_alert('用户名或密码错误！');
        }
    }

    $bp3_tag->assign("login_baidu_url",$login_baidu_url);

    display();
