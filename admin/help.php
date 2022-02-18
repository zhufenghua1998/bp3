<?php
// 文件管理
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    force_login();//强制登录
    // 获取open地址
    $index_url = get_base_url("/admin/help.php");
    $open_url = $index_url."/open.php";
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
    
    <h3>当前版本</h3>
    <p>您当前使用的版本号是：<?php echo $config['version'];?> </p>
    <p>由于github网络问题，暂无法为您提供在线更新，请自助更新</p>
    
    <h3>如何配置前台开放目录？</h3>
    <p>在设置中，写上要省略的前置目录，例如：</p>
    <ul>
        <li>开放根目录：留空</li>
        <li>开放/apps目录：填写/apps，注意结尾不要/</li>
    </ul>
    
    <h3>如何重置系统？</h3>
    <p>请把根目录下config.php文件删除，会重置本系统</p>
    <h3>账户已经锁定？</h3>
    <p>为防止暴力破解，一旦账户密码连续错误3次，将会锁定，暂需手动恢复</p>
    <p>请ftp后，编辑根目录下的config.php文件，把 user => chance 选项设置为3</p>
    
    <h3>忘记账户密码？</h3>
    <p>请ftp后，编辑根目录下的config.php文件，其中user=>name为账户名，user=>pwd为密码。</p>
    
    <h3>开发者获取token接口</h3>
    <p>bp3当前使用的access_token可以被其他程序获取，为了安全起见仅本机程序(同IP地址)可以获取，地址如下：</p>
    <pre><?php echo $open_url; ?></pre>
    <p>例如，你可以使用以下python代码获取access_token</p>
    <pre><code>from urllib import request
    
resp = request.urlopen('<?php echo $open_url;?>')
print(resp.read().decode())</code></pre>
    <p>如果你希望直接取得token用于测试，请<a href="../open.php" target="_blank">点击查看</a>。</p>
    <h3>其他问题</h3>
    <p>参阅百度网盘开发者官方文档：<a href="https://pan.baidu.com/union/doc/" target="_blank">百度网盘开发者文档</a></p>
    <p>如需帮助，请在github发布issure，或者QQ交流群：1150064636</p>
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
    // 复制代码
    $("pre").mouseenter(function (e) {
        var _that = $(this);
        _that.css("position", "relative");
        _that.addClass("activePre");
        var copyBtn = _that.find('.copyBtn');
        if (!copyBtn || copyBtn.length <= 0) {
            var copyBtn = '<span class="copyBtn" style="position:absolute;top:2px;right:2px;z-index:999;padding:2px;font-size:13px;color:black;background-color: white;cursor: pointer;" onclick="copyCode()">Copy</span>';
            _that.append(copyBtn);
        }
    }).mouseleave(function (e) {
        var _that = $(this);
        var copyBtn = _that.find('.copyBtn');
        var copyBtnHover = _that.find('.copyBtn:hover');
        if (copyBtnHover.length == 0) {
            copyBtn.remove();
            _that.removeClass("activePre");
        }
    });
    function copyCode() {
        var activePre = $(".activePre");
        activePre = activePre[0];
        var code = activePre.firstChild;
        if(code.nodeName=="CODE"){
            activePre = code;
        }
        var clone = $(activePre).clone();
        clone.find('.copyBtn').remove();
        var clipboard = new ClipboardJS('.copyBtn', {
            text: function () {
                return clone.text();
            }
        });
        clipboard.on("success", function (e) {
            $(".copyBtn").html("Copied!");
            clipboard.destroy();
            clone.remove();
        });

        clipboard.on("error", function (e) {
            clipboard.destroy();
            clone.remove();
        });
    }
</script>
</body>
</html>