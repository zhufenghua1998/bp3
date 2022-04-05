<?php

    // session域解析版
    require_once("../functions.php");

    // 未登录，重定向至登录页面
    if(!check_session("access_token")){
        redirect("./login.php");
    }
    // 正在注销
    if($_GET['logout']){
        $_SESSION['access_token'] = null;
        redirect("./login.php");
    }

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页 | bp3免部署版</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./">bp3免部署版</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li class="active"><a href="./">首页<i class="fa fa-home"></i></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">返回<?php echo $config['site']['title'];?><i class="fa fa-map" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $config['site']['blog'];?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $config['site']['github'];?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
            <li><a href="./index.php?logout=1">注销<i class="fa fa fa-sign-out" aria-hidden="true"></i></a></li>
          </ul>
    
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
 <div class="container">

    <h2>前言</h2>
    <p>当你看到这里，就已经成功登录bp3免部署版了</p>
    <p>您的百度昵称：<?php echo $_SESSION['baidu_name']; ?></p>
    <p>网盘昵称：<?php echo $_SESSION['netdisk_name']; ?></p>
    <h2>功能列表</h2>
    <p>这是一个受限的功能列表，您可以：</p>
    <ul>
        <li><a href='file.php'>进行文件管理</a></li>
    </ul>
</div>
<footer class="copyright">
    <div class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo "bp3"?> <?php echo date('Y')?></p>
    </div>
</footer>
<style>
   body { padding-bottom: 70px; }
    .copyright,.navbar-inverse{
        margin-bottom: 0px;
    }
   .container p{
       font-size: 1.2em;
   }
</style>
</body>
</html>
