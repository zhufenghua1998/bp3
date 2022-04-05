<?php 
    require_once("../functions.php");

    if($open_session==0){
        force_login();//强制登录
    }

    // 已登陆，重定向
    if(check_session("access_token")){
        redirect($dir_url);
    }
    
    // 正在登录
    $param = $_GET['param'];
    if(isset($param)){
        $obj = json_decode($param);
        
        $access_token = $obj-> access_token;
        
        $url2 = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$access_token&method=uinfo";
        
        $basic = easy_file_get_content($url2);
        
        if(isset($basic)){
            $_SESSION['access_token'] = $obj->access_token;
            
            $arr = json_decode($basic,true);
            
            $_SESSION['baidu_name'] = $arr['baidu_name'];
            $_SESSION['netdisk_name'] = $arr['netdisk_name'];
            
        }
        
        redirect($dir_url);
    }
    
    if($_SESSION['access_token']){
        $action = '管理';
    }else{
        $action = '登录';
    }

    // 未登陆，给出登录方法
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录 | bp3免部署版</title>
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
            <li ><a href="./">首页<i class="fa fa-home"></i></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./login.php"><?php echo $action;?><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></li>
            <li><a href="../">返回<?php echo $title;?><i class="fa fa-map" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $blog;?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $github;?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
          </ul>
    
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
 <div class="container">

    <h2>bp3免部署版是什么？</h2>
    <p>bp3免部署版，可以无需部署任何代码，访问网页即可授予bp3全部功能</p>
    <p>但是，过多的访客来执行处理复杂的功能，需要服务器硬件的支持，所以实际上仅开放了少量功能</p>
    <p>您能够访问本页面，也是站点管理员开放的结果，请按下面的步骤登录并使用吧</p>
    <h2>怎么进行登录？</h2>
    <p>登录依赖于bp3的授权系统，但是注意：<b>必须从本页面跳转授权系统</b></p>
    <p>免app授权系统，请点击 => <a href="<?php echo "$grant_url?display=$enc_page_url"; ?>">跳转bp3授权系统</a></p>
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