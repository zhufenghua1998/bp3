<?php 
    require_once("./functions.php");
    // 校验是否配置百度登录
    $bind_baidu = false;
    if(isset($config) && isset($config['identify']) && isset($config['account'])){
        $bind_baidu = true;
    }
    $login_baidu_url = null;
    if($bind_baidu){

        $login_controller = urlencode($baidu_login_url);

        $login_baidu_url = "$grant_url?display=$login_controller"; // 快速登录百度地址
    }


    $name = isset($_POST['user'])?$_POST['user']:null;
    $pwd = isset($_POST['pwd'])?$_POST['pwd']:null;

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
            js_alert('账户已经锁定！有两个办法解决。\n办法一：ftp编辑或删除config.php、并刷新缓存\n刷新缓存办法：关闭并重新打开浏览器\n办法二：使用百度账户登录');
        }
        else{
            js_alert('用户名或密码错误！');
        }
    }
    $bp3_tag->assign("check_login",$check_login);
    $bp3_tag->assign("admin_url",$admin_url);


    $bp3_tag->assign("login_baidu_url",$login_baidu_url);

    display();
