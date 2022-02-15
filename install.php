<?php
    
    require_once("./conf_base.php");
    require_once("./functions.php");
    
    $init = false;
    if(file_exists("./config.php"))
    {
        $init = true;
    }
    
    $dirUrl = getDirUrl(basename(__FILE__));
    $redirect = $dirUrl."grant2/callback.php";  // redirect_uri
    $grant_url = $dirUrl."grant2/";
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $app = $_POST['app'];
    $secret = $_POST['secret'];
    
    if(!empty($username) && !$init){
        
        $init = true;
        
        $config = $config_base;
        
        $config['user']['name']=$username;
        $config['user']['pwd']=$password;
        $config['identify']['grant_url']=$grant_url;

        save_config('./config.php');
        
        
        echo "<script>alert('提交成功！正在前往登录页面...');window.location.href='./login.php';</script>";
    }else if(!empty($username)){
        echo "<script>alert('你已经配置过了，如果需要重新配置，请把config.php文件删掉');window.location.href='./login.php';</script>";
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
            <p>如果本次配置未能成功，请把config.php删掉并重新访问本页面</p>
            <p>现在就开始配置吧：</p>
            <form method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">bp3账户名</label>
                <input name="username" type="text" class="form-control" id="exampleInputEmail1" required="required" placeholder="UserName">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">bp3密码</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" required="required" placeholder="Password">
              </div>
              <div class="form-group">
                  <label for="app">填写AppKey</label>
                  <input name="app" class="form-control" placeholder="请填写应用AppKey" id="app" value="无需填写" readonly="readonly" required="required"/>
              </div>
              <div class="form-group">
                  <label for="secret">填写SecretKey</label>
                  <input name="secret" class="form-control" placeholder="请填写应用SecretKey" value="无需填写" readonly="readonly" id="secret" required="required"/>
              </div>
              <div class="form-group">
                  <label for="redirect_uri">配置回调地址</label>
                  <input name="redirect" type="text" class="form-control" id="redirect_uri" readonly="readonly" value="无需填写">
              </div>
            
              <p class="text-center"><button type="submit" class="btn btn-default">提交</button></p>
            </form>
        </div>
    </body>
</html>
