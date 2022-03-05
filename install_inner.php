<?php
    // 快速配置
    $config = require('./conf_base.php');
    require_once("./functions.php");
    
    $init = false;
    if(file_exists("./config.php"))
    {
        $init = true;
    }
    
    $username = $_POST['username'];
    
    $pageUrl = urlencode(get_page_url());
    
    $dirUrl = get_dir_url(basename(__FILE__));
    
    $grant_url = $dirUrl.'grant2/';

    // 如果请求初始化($username非空)，且还未初始化（init==0）
    if(!empty($username) && !$init){
        
        $config['user']['name']= $_POST['username'];
        $config['user']['pwd']= $_POST['password'];
        
        
        $config['identify']['grant_url'] = $grant_url;
        
        save_config("./config.php"); 
        
        echo "<script>alert('提交成功！正在前往登录页面...');window.location.href='./login.php';</script>";
    }else if(!empty($username)){
        // 请求初始化，但已经初始化了
        echo "<script>alert('你已经配置过了，如果需要重新配置，请把config.php文件删掉');window.location.href='./login.php';</script>";
    }
    
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bp3 | 初始化内置app授权系统</title>
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
            <h3 class="text-center">欢迎使用bp3，正在初始化内置app系统</h3>
            <p>这里操作非常简单，您只需要自定义bp3账户和密码即可</p>
            <p>如果本次配置未能成功，请把config.php删掉并重新访问本页面</p>
            <form method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">bp3账户名</label>
                <input name="username" type="text" class="form-control" id="exampleInputEmail1" placeholder="UserName">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">bp3密码</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <p class="text-left"><button type="submit" class="btn btn-primary">提交</button></p>
            </form>
            <p><b>提示：</b>安装完毕后，可在后台调整配置app，或者免app授权，以及内置app三种授权方式。</p>
            <p><b>提示：</b>如果安装遇到问题，可在github求助，或QQ交流群：1150064636。</p>
            <p><a href="./install.php">返回配置app授权</a> 或 <a href="./install_fast.php">前往免app初始化</a></p>
        </div>
    </body>
</html>
