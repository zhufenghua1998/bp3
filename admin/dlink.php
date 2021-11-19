<?php
    session_start();
/**
 *  文件下载模块，访客权限可用
 */
    // 1.获取fsid
    $fsid =  $_GET['fsid'];
    if(empty($fsid)){
        echo '无效fsid';
        die;
    }
    $user = $_SESSION['user'];
    if(empty($user)){
        echo '未登录';
        die;
    }
    require_once('../config.php');
    require_once('../functions.php');
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=$access_token&method=filemetas&fsids=[$fsid]&dlink=1&thumb=1&dlink=1&extra=1";
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'User-Agent: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    $json = json_decode($result);
    $dlink =  $json->list[0]->dlink;
    $file_size = $json->list[0]->size;
    $file_name = $json->list[0]->filename;
    $dlink = $dlink.'&access_token='.$access_token;
    $show_size = height_show_size($file_size);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>获取直链 | bp3</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/clipboard.min.js"></script>
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
            <li><a href="./help.php">帮助与支持<i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
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
    <h2 class="h3">获取直链，仅针对chrome内核浏览器(chrome, edge, 360极速等)</h2>
    <p>在使用前安装<a href="./bp3_ua.zip" target="_blank">bp3_ua</a>扩展，安装后选中52dixiaowo下的bp3-default选项即可</p>
    <p>当前预下载文件：<?php echo $file_name;?>，大小：<?php echo $show_size;?></p>
    <p>点击以下链接（有效期8小时）即可自动下载：</p>
    <p><a class="br" target="_blank" href="<?php echo $dlink;?>" download><?php echo $dlink;?></a></p>
    <p><b>提示：</b>需要User-Agent是：pan.baidu.com，您当前：<?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
    <p><b>提示</b>：由于浏览器或其他原因点击不下载，尝试手动粘贴URL可解决。造成的原因是：“混合下载”，由下载地址多次重定向且最终由http协议连接加载而导致chrome对下载地址的不信任，但最终是可以下载的。</p>
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
    .br{
        word-break: break-all;
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