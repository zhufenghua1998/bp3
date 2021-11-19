<?php
// 文件管理
    session_start();
    $user = $_SESSION['user'];
    if(!$user){
        echo '您还未登陆。';
        die;  // 终止后续解析
    }
    require('../config.php');
    require_once("../functions.php");
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
    <p>①如何配置回调地址？当前admin路径下的connect.php，即<a target="_blank" href="./connect.php">connect.php</a></p>
    <p>②如何配置前台开放目录？在后台设置中，写上要省略的前置目录，例如：</p>
    <ul>
        <li>开放根目录：留空</li>
        <li>开放/apps目录：填写/apps，注意结尾不要/</li>
    </ul>
    <p>③更换网站图标？替换网站根目录的favicon.ico文件</p>
    <h3>文件上传描述</h3>
    <p>bp3在某些功能的实现上，比如<b>大文件上传</b>，是困难的。</p>
    <p>如果只是想上传文件，直接转到<a href="https://pan.baidu.com">百度网盘网页版</a>，bp3后台中可以快速定位到<b>百度网盘网页版相同目录</b></p>
    <p>我们在设置中添加了2个位置以便在bp3中存放您的百度账户信息，以便从bp3无缝跳转百度网盘网页版</p>
    <p>直接上传大文件的解决方案，还有待进一步研究，您也可以向我们提供建议，或加入我们一起做出贡献。</p>
    <h3>开发者获取token接口</h3>
    <p>bp3为其他应用提供token，为了安全起见目录仅本机可以获取，地址如下：</p>
    <pre><?php echo $open_url; ?></pre>
    <p>例如，你可以使用以下python代码获取access_token</p>
    <pre><code>from urllib import request
    
resp = request.urlopen('<?php echo $open_url;?>')
print(resp.read().decode())</code></pre>
    <h3>快速授权解决方案</h3>
    <p>通常来说，你应该申请一个百度网盘开发者app，但这样的步骤实际上是繁琐的</p>
    <p>通过测试，该过程是可以省略的，只需要有一个授权程序部署，不同的用户就都可以从该程序中获取<code>access_token</code></p>
    <p>而只要获得access_token，以及refresh_token，就可以一直刷新使用有效期长达10年，为此bp3将开发一个辅助简化的授权系统。</p>
    <p>快速授权程序实际是安全的，因为无论该程序部署者是谁，只要它不保存、窃取你的access_token，那么它实际无法访问你的数据，同时你也可以在<a href="https://passport.baidu.com/v6/appAuthority">百度授权管理</a>中取消该应用授权</p>
    <p>作为bp3配套的授权程序，它也是开源的，敬请等待！</p>
    <h3>bp3二次开发</h3>
    <p>百度网盘开发者官方文档为：<a href="https://pan.baidu.com/union/doc/" target="_blank">百度网盘开发者文档</a>，但它并不够详细，我们将在后续制作一份更详细的文档，敬请等待！</p>
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