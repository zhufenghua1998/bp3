<?php 
    session_start();

    require_once("../functions.php");
    $url = './index.php';
    // 已登陆，重定向
    if($_SESSION['access_token']){
        header("Location: $url");
    }
    
    // 正在登录
    $param = $_GET['param'];
    if(isset($param)){
        $obj = json_decode($param);
        $_SESSION['access_token'] = $obj->access_token;
        header("Location: $url");
    }
    // 未登陆，给出登录方法
    $page_url = getPageUrl();
    
    $enc_page_url = urlencode($page_url);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录 | bp3解析版</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body style="background-image: url(../img/bg.png);">
 
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
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo $config['site']['blog'];?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $config['site']['github'];?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
          </ul>
    
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

<div class="container-fluid">
    <p class="h2">请点击<a href="https://bp3.52dixiaowo.com/grant/?display=<?php echo $enc_page_url; ?>">链接</a>进行登录</p>
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
</style>
</body>
</html>