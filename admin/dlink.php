<?php
    session_start();
    require_once('../config.php');
    require_once('../functions.php');
/**
 *  文件下载模块，访客权限使用时需管理员开启
 */
    // 1.获取fsid
    $fsid =  $_GET['fsid'];
    if(empty($fsid)){
        echo '无效fsid';
        die;
    }
    if($config['control']['pre_link']!=0){
        $user = $_SESSION['user'];
        if(empty($user)){
            echo '未登录';
            die;
        }
    }

    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=$access_token&method=filemetas&fsids=[$fsid]&dlink=1&thumb=1&dlink=1&extra=1";
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'User-Agent: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    $json = json_decode($result);
    $dlink =  $json->list[0]->dlink;
    $file_size = $json->list[0]->size;
    $file_name = $json->list[0]->filename;
    $dlink = $dlink.'&access_token='.$access_token;
    $show_size = height_show_size($file_size);
    $check_ua = $_SERVER['HTTP_USER_AGENT']=="pan.baidu.com"?"text-success":"text-danger";
    $headerArray = array('User-Agent: pan.baidu.com');
    $getRealLink = head($dlink, $headerArray); // 禁止重定向
	$getRealLink = strstr($getRealLink, "Location");
	$realLink =  substr($getRealLink, 10);
	$realLink = substr($realLink,0,strpos($realLink,"\n")-1);
	$client_link = $realLink."&filename=|".$file_name;
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
          <a class="navbar-brand <?php if(empty($_SESSION['user'])) echo "hidden" ?>" href="./">管理系统</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav <?php if(empty($_SESSION['user'])) echo "hidden" ?>">
            <li><a href="./file.php">文件管理<i class="fa fa-th-large" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
            <li><a href="./settings.php">修改设置<i class="fa fa-cog"></i></a></li>
            <li><a href="./help.php">帮助与支持<i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../">前台<i class="fa fa-home"></i></a></li>
            <li class="<?php if(empty($_SESSION['user'])) echo "hidden" ?>"><a href="./logout.php">注销<i class="fa fa-sign-out" aria-hidden="true"></i></i></a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  
    </div>
    </header>
<main>
<div class="container help">
    <h2 class="h3">当前正在使用bp3直链功能：</h2>
    <p>当前预下载文件：<?php echo $file_name;?>，大小：<?php echo $show_size;?></p>
    <p>本次链接创建于<?php echo date("Y-m-d H:i:s");?>，以下链接8小时内有效：</p>
    <div class="text-info">
        点击==><button id="cbtn1">复制链接</button>
    </div>
    <h2>通用下载方式：</h2>
    <p>这是一些通用的解决方案，需要设置user-agent：pan.baidu.com</p>
    <p>IDM、aria2、Motrix、Pure浏览器(Android)、Alook浏览器(IOS)</p>
    <h2>bp3_client</h2>
    <p>这是bp3提供的客户端</p>
    <p>若首次使用，请下载 <a href="./bp3_client_win_x64.zip">bp3客户端（仅windows x64）</a>，解压后点击bp3_client.exe运行，右键粘贴并回车即可下载</p>
    <p><b>提示：</b>若无法右键粘贴，请右键点击窗口顶部=》编辑=》粘贴</p>
    <p><b>提示：</b>下载后的文件，存放在download目录</p>
    <p><b>提示：</b>如果发现下载失效，可能是版本更新所致，请点击上述链接下载新版客户端</p>
    <h2>bp3_ua</h2>
    <p><b>提示：</b>chrome系列可下载<a href="./bp3_ua.zip" target="_blank">bp3_ua</a>扩展，安装后选中52dixiaowo下的bp3-default选项即可</p>
    <p><b>提示：</b>需要User-Agent是：pan.baidu.com，您当前：<?php echo "<span class='$check_ua'>".$_SERVER['HTTP_USER_AGENT']."</span>"; ?></p>
    <p><b>提示：</b>请粘贴链接到chrome地址栏上即可下载</p>
    <p><b>提示</b>：由于下载地址多次重定向且最终由http协议连接加载而导致chrome对下载地址的不信任，手动点击保存文件即可</p>
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
        white-space: normal;
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
        // 获取此html元素
    var clipboard1 = new ClipboardJS('#cbtn1', {
        text: function() {
            return `<?php echo $client_link; ?>`;
        }
    });
// 复制成功事件
    clipboard1.on('success', function(e) {
        alert("复制成功")
    });
// 复制失败事件
    clipboard1.on('error', function(e) {
        alert("复制失败")
    });
</script>
</body>
</html>