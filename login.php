<?php 
    session_start();
    require("./config.php");
    require_once("./functions.php");
    $url = './admin';
    // 已登陆，重定向
    if($_SESSION['user']){
        header("Location: $url");
    }
    // 未登陆
    $name = $_POST['user'];
    $pwd = $_POST['pwd'];
    $lock = $config['user']['lock'];
    $chance =$config['user']['chance'];
    // 用户密码为空，不处理
    if(!$name && !$pwd){
        // 表示未输入
    }
    else if($config['user']['name']==$name && $config['user']['pwd']==$pwd && $chance>0){
        // 登陆成功
        $_SESSION['user'] = $name;
        $_SESSION['expiretime'] = time() + 3600;
        // 重置机会
        $config['user']['chance']=$lock;
        save_config("./config.php");
        header("Location: $url");
    }else{
        // 次数减少
        $chance--;
        $config['user']['chance'] = $chance;
        save_config("./config.php");
        if($chance<=0){echo "<script>alert('账户已经锁定！')</script>";}
        else{echo "<script>alert('用户名或密码错误！')</script>";}
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登陆 | <?php echo $config['site']['title'];?></title>
    <link href="./favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body style="background-image: url(./img/bg.png);">
 
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
            <li><a href="./">首页<i class="fa fa-home"></i></a></li>
          </ul>
          <form class="navbar-form navbar-left" action="./">
            <div class="form-group">
              <input type="text" name="s" class="form-control" placeholder="搜索文件" required="required">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./login.php">登录<i class="fa fa-user-circle-o" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $config['site']['blog'];?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $config['site']['github'];?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
            <li><a href="./about.php">关于<i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
          </ul>
    
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="modal-dialog" style="margin-top: 10%;">
        <form method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="myModalLabel">登录</h4>
            </div>
            <div class="modal-body" id = "model-body">
                <div class="form-group">
 
                    <input type="text" class="form-control"placeholder="用户名" autocomplete="off" name="user">
                </div>
                <div class="form-group">

                    <input type="password" class="form-control" placeholder="密码" autocomplete="off" name="pwd">
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control">登录</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal -->
<footer class="copyright">
    <div class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo $config['site']['title'];?> <?php echo date('Y')?></p>
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