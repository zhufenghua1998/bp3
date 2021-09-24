<?php
    session_start();
    require('config.php');
    if($_SESSION['user']){
        $action = '管理';
    }else{
        $action = '登录';
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>关于 | <?php echo $config['site']['title'];?></title>
    <link href="./favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body style="background-color:rgb(231,231,231);">
 
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
          <a class="navbar-brand" href="./"><?php echo $config['site']['title'];?></a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li><a href="./">首页<i class="fa fa-home" aria-hidden="true"></i></a></li>
          </ul>
          <form class="navbar-form navbar-left" action="./">
            <div class="form-group">
              <input type="text" required="required" name="s" class="form-control" placeholder="搜索文件">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.php"><?php echo $action;?><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $config['site']['blog'];?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $config['site']['github'];?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
            <li class="active"><a href="./about.php">关于<i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
          </ul>
    
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
<main>
    <div class="container content">
        <h2>简介</h2>
        <p>bp3是一个php开发的网盘程序，开源免费易使用。</p>
        <p>bp3不使用服务器存储数据，而是对接百度网盘，可以直接从你的百度网盘上下载资源。</p>
        <h2>功能概述</h2>
        <p>bp3是最佳的百度网盘管理程序，包括但不限于：</p>
        <ul>
            <li>下载文件</li>
            <li>上传文件</li>
            <li>管理文件，如：移动拷贝等</li>
        </ul>
        <h2>安装、部署</h2>
        <p>1.从github上下载程序源代码</p>
        <p>2.部署到服务器上，推荐环境php74</p>
        <p>3.配置百度网盘信息</p>
        <p>4.完成</p>
    </div>
</main>
<footer class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo $config['site']['title'];?> <?php echo date('Y')?></p>
</footer>
<style>
   body { padding-bottom: 70px; }
   .content{
       font-size: 1.2em;
   }
</style>
</body>
</html>