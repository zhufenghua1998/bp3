<?php
    // 体验版
    $config_file = "./config.php";
    require_once($config_file);
    require_once("./functions.php");
    //仅在config['init']==false时该配置才可生效
    $init = $config['init'];
    
    $identify = $_GET['param'];
    $json = null;
    
    // 如果存在参数param
    if(isset($identify)){
        $identify = urldecode($identify);
        $json = json_decode($identify,true);
        
        $json['conn_time'] = time();
    }
    
    $pageUrl = urlencode(getPageUrl());
    
    $dirUrl = getDirUrl(basename(__FILE__));
    
    $redirect = $dirUrl.'admin/connect.php';

    // 如果存在参数，且还未初始化
    if(!empty($identify) && !$init){
        $init = true;
        $config['user']['name']='bp3';
        $config['user']['pwd']='bp3';
        $config['init']=$init;
        $config['connect']['redirect_uri']=$redirect;
        $config['identify'] = $json;
        
        // 2.获取basic
        $token = $config['identify']['access_token'];
        $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
        $result = file_get_contents($url,false);
        $json = json_decode($result);
        $config['basic']['baidu_name'] = $json->baidu_name;
        $config['basic']['netdisk_name'] = $json->netdisk_name;
        $config['basic']['uk'] = $json->uk;
        $config['basic']['vip_type'] = $json->vip_type;
        //
        $text='<?php $config='.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
        echo "<script>alert('提交成功！正在前往登录页面...');window.location.href='./login.php';</script>";
    }else if(!empty($identify)){
        echo "<script>alert('你已经配置过了，如果需要重新配置，请把conf_base.php文件覆盖config.php文件');window.location.href='./login.php';</script>";
    }
    
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bp3 | 免app体验版</title>
        <link href="./favicon.ico" rel="shortcut icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <link href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <style>
            body{
                background-color: #f0f0f1;
            }
            .container{
                background-color: #fff;
                margin: 100px auto;
                font-size: 1.2em;
            }
            .container > p{
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3 class="text-center">欢迎使用bp3，正在体验免app配置</h3>
            <p>免app配置时，默认账户密码均为bp3</p>
            <p>请从以下列表中选取一个快速授权地址，并访问：</p>
            <ol>
                <li><a href="https://bp3.52dixiaowo.com/grant/?display=<?php echo $pageUrl;?>">bp3官方</a></li>
            </ol>
            <p>任意点击上面在一个地址，进行账户授权，即可自动完成</p>
            <p><b>提示：</b>如果上述地址均不可用，请手动获取授权原始信息，并粘贴到下面：</p>
            <form method="get">
                <textarea name="param" rows="4" cols="30" placeholder="请粘贴授权原始信息"></textarea>
                <p><input type="submit" value="提交"></p>
            </form>
            <p><b>提示：</b>如果后期需要内置app，请在后台填写并在后台重新授权连接</p>
            <p><b>提示：</b>如果安装遇到问题，可在github求助。</p>
        </div>
    </body>
</html>
