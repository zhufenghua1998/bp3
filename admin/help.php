<?php
// 文件管理
    session_start();
    $user = $_SESSION['user'];
    if(!$user){
        echo '您还未登陆。';
        die;  // 终止后续解析
    }
    require('../config.php');

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>帮助与支持 | bp3</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>

</head>
<body style="background-color:rgb(231,231,231);">
 
    <header >
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
          <a class="navbar-brand" href="./">管理系统</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav">
            <li><a href="./file.php">文件管理<i class="fa fa-th-large" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
            <li><a href="./settings.php">修改设置<i class="fa fa-cog"></i></a></li>
            <li class="active"><a href="./help.php">帮助与支持<i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">前台<i class="fa fa-home"></i></a></li>
            <li><a href="./logout.php">注销<i class="fa fa-sign-out" aria-hidden="true"></i></i></a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  
    </div>
    </header>
<main>
<div class="container help">
    <h3>答疑解惑</h3>
    <p>①如何配置回调地址？当前admin路径下的connect.php，即<a href="./connect.php">connect.php</a></p>
    <p>②如何配置前台开放目录？在后台设置中，写上要省略的前置目录，例如：</p>
    <ul>
        <li>开放根目录：留空</li>
        <li>开放/apps目录：填写/apps，注意结尾不要/</li>
    </ul>
    <p>③更换网站图标？替换网站根目录的favicon.ico文件</p>
    <h3>bp3相关网址</h3>
    <ul>
        <li><a href="https://www.baidu.com">百度网页版</a></li>
        <li><a href="https://passport.baidu.com/v6/appAuthority">百度授权管理</a></li>
        <li><a href="https://pan.baidu.com">百度网盘网页版</a></li>
        <li><a href="https://pan.baidu.com/union/console/applist?from=header">百度网盘开发者控制台</a></li>
    </ul>
    <h3>bp3二次开发</h3>
    <p>基于bp3进行二次开发，或对bp3进行修改，需要掌握一定的php与前端开发技术，QQ交流群：1150064636</p>
</div>

</main>
<footer class="navbar navbar-default navbar-fixed-bottom navbar-inverse copyright">
<p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © bp3 <?php echo date('Y')?></p>
</footer>
<style>
    .copyright{
        margin-bottom: 0px;
    }
    .help{
        font-size: 1.1em;
    }
    .help p{
        text-indent: 2em;
    }
</style>
<script>
    $(function () {
      if($(window).height()==$(document).height()){
        $(".copyright").addClass("navbar-fixed-bottom");
      }
      else{
        $(".copyright").removeClass(" navbar-fixed-bottom");
      }    
    });
</script>
</body>
</html>