<?php

    $config_file = "./config.php";
    require_once($config_file);
    require_once("./functions.php");
    //仅在config['init']==false时该配置才可生效
    $init = $config['init'];
    $dirUrl = getDirUrl(basename(__FILE__));
    $redirect = $dirUrl."grant/callback.php";  // redirect_uri
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $app = $_POST['app'];
    $secret = $_POST['secret'];
    
    if(!empty($username) && !$init){
        
        $init = true;
        $config['init']=$init;
        $config['user']['name']=$username;
        $config['user']['pwd']=$password;
        $config['connect']['app_id']=$app;
        $config['connect']['secret_key']=$secret;
        $config['connect']['redirect_uri']=$redirect;
        $text='<?php $config='.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
        
        
        echo "<script>alert('提交成功！正在前往登录页面...');window.location.href='./login.php';</script>";
    }else if(!empty($username)){
        echo "<script>alert('你已经配置过了，如果需要重新配置，请把conf_base.php文件覆盖config.php文件');window.location.href='./login.php';</script>";
    }

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bp3 | 安装配置文件</title>
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
            <h3 class="text-center">欢迎使用bp3，当前正在配置config.php文件</h3>
            <p>您当前正在使用"一键配置"</p>
            <p>如果本次配置未能成功，请把conf_base.php覆盖config.php重新配置</p>
            <h3><b>提示：</b>已推出免app方式，无须任何配置<a href="./install_fast.php">点击体验</a></h3>
            <p>如果非免app配置，你需要明白，使用本程序需要申请成为百度网盘开发者，并申请App，点击跳转<a href="https://pan.baidu.com/union/console/applist" target="_blank">百度网盘开发者控制台</a></p>
            <p>现在就开始配置吧：</p>
            <form method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">bp3账户名</label>
                <input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">bp3密码</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                  <label for="app">填写AppKey</label>
                  <input name="app" class="form-control" placeholder="请填写应用ID" id="app" required="required"/>
              </div>
              <div class="form-group">
                  <label for="secret">填写SecretKey</label>
                  <input name="secret" class="form-control" placeholder="请填写应用密钥" id="secret" required="required"/>
              </div>
              <div class="form-group">
                  <label for="redirect_uri">配置回调地址</label>
                  <input name="redirect" type="text" class="form-control" id="redirect_uri" readonly="readonly" value="<?php echo $redirect;?>">
              </div>
            
              <p class="text-center"><button type="submit" class="btn btn-default">提交</button></p>
            </form>
        </div>
    </body>
</html>
