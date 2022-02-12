<?php
// 文件管理
    session_start();
    require('../config.php');
    require_once("../functions.php");
    force_login();//强制登录
    // 获取open地址
    $page_url = getPageUrl();
    $index_url = str_replace("/admin/help.php","",$page_url); 
    $open_url = $index_url."/open.php"; // 
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
    <h3>配置相关</h3>
    <p>①如何配置回调地址？部署根目录下<a id="callback_2" target="_blank">/grant/callback.php</a>，即 <span id="callback"></span></p>
    <p>②如何配置前台开放目录？在后台设置中，写上要省略的前置目录，例如：</p>
    <ul>
        <li>开放根目录：留空</li>
        <li>开放/apps目录：填写/apps，注意结尾不要/</li>
    </ul>
    <p>③更换网站图标？替换网站根目录的favicon.ico文件</p>
    <p>④需要重新配置？请把根目录下conf_base.php文件内容覆盖config.php文件，会重置本系统</p>
    <p>⑤账户密码修改？账户锁定？请查看并编辑config.php，该文件包含所有配置。</p>
    <h3>其他功能描述</h3>
    <p>bp3在某些功能的实现上，比如<b>大文件上传</b>，是困难的。</p>
    <p>如果只是想上传文件，直接转到<a href="https://pan.baidu.com">百度网盘网页版</a>，bp3后台中可以快速定位到<b>百度网盘网页版相同目录</b></p>
    <p>我们在设置中添加了2个位置以便在bp3中存放您的百度账户信息（防遗忘），以便从bp3无缝跳转百度网盘网页版</p>
    <p>对于文件的其他管理，我们也推荐在百度网盘网页版，在bp3中仅提供了少量的文件管理功能。</p>
    <p>直接上传大文件的解决方案，还有待进一步研究，您也可以向我们提供建议，或加入我们一起做出贡献。</p>
    <h3>开放app授权接口</h3>
    <p>bp3的授权系统可以为其他程序提供授权，这也是bp3免app配置的原理</p>
    <p>但默认情况下，该功能并不开放给游客（即登录后可用），如果希望开启，请设置open_grant的值为1</p>
    <p>当前系统内置授权地址是：根目录下的<a target="_blank" id="grant_2">grant/index.php</a>，即 <pre id="grant"></pre></p>
    <p>当携带display的get参数时，则会在授权后自动携带结果重定向</p>
    <pre><code>// 假设授权地址：https://bp3.52dixiaowo.com/grant/
// 假设重定向后地址是：https://bp3.52dixiaowo.com/install_fast.php

// 那么携带display参数(需要urlencode)时应该这样授权：

https://bp3.52dixiaowo.com/grant/?display=https%3A%2F%2Fbp3.52dixiaowo.com%2Finstall_fast.php</code></pre>
    <h3>开发者获取token接口</h3>
    <p>bp3当前使用的access_token可以被其他程序获取，为了安全起见仅本机程序(同IP地址)可以获取，地址如下：</p>
    <pre><?php echo $open_url; ?></pre>
    <p>例如，你可以使用以下python代码获取access_token</p>
    <pre><code>from urllib import request
    
resp = request.urlopen('<?php echo $open_url;?>')
print(resp.read().decode())</code></pre>
    <p>如果你希望直接取得token用于测试，请<a href="../open.php" target="_blank">点击查看</a>。</p>
    <h3>bp3二次开发</h3>
    <p>百度网盘开发者官方文档为：<a href="https://pan.baidu.com/union/doc/" target="_blank">百度网盘开发者文档</a>，但它可能有所欠缺，可参阅<b>52的小窝</b>维护的<a href="https://www.52dixiaowo.com/post-3245.html" target="_blank">php版百度网盘开发者文档</a></p>
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
      let loc = location.toString();
      loc = loc.substring(0,loc.length-14)
      let callback = loc+"grant/callback.php"
      $("#callback").text(callback);
      $("#callback_2")[0].href=callback;
      let grant = loc+"grant/index.php"
      $("#grant").text(grant);
      $("#grant_2")[0].href=grant;
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