<?php

    require_once("../functions.php");

    if($open_grant==0){
        force_login();
    }
        
    // 允许携带重定向参数，参数为get，参数名display
    // 携带参数访问本页面，则在获取授权后携带结果重定向请求参数地址
    $display = $_GET['display'];
    if(isset($display)){
        // 存在redirect参数
        $_SESSION['display'] = $display;
    }else{
        // 不存在重定向，则在默认页面显示
        $_SESSION['display'] = "display";
    }
    
    
    // 1. 获取基础信息
    $title = $config['site']['title'];
    $app_id = $config['connect']['app_id'];
    $redrect_uri = $config['connect']['redirect_uri'];
    
    // 2. 拼接授权信息
    $state = rand(10,100);
    $_SESSION['state'] = $state;
    
    // 2.1自动检测链接
    $conn = "https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$app_id&redirect_uri=$redrect_uri&scope=basic,netdisk&display=popup&state=$state&confirm_login=1&login_type=sms";
    // 2.2强制登录链接
    $force_conn = $conn.'&force_login=1';
    // 3. 点击下面的链接以获取token
?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title><?php echo '免app授权系统'.' | '.$config['site']['title'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    </head>
    <body>
        <h2 class="text-center">这是<a href="..">bp3</a>的免app授权系统</h2>
        <div class="container">
            <h2>授权方式一：网页登录</h2>
            <p>通过在网页中快速检测已登录账户，或者使用短信登录、或者账户密码登录</p>
            <p>点击右边的链接，然后获取授权
                ==><a id="link" href="<?php echo $conn;?>">授权链接</a></p>
            <p><b>提示：</b>默认自动检测当前登录的百度账号，
            如果不希望检测，请勾选<input id="force" type="checkbox"/><label for="force">强制登录</label></p>
            <br>
            <h2>授权方式二：扫码登录</h2>
            <p>通过百度网盘app或者百度app扫描网页中的二维码，然后快速登录</p>
            <p>点击右边的链接，然后生成二维码
                ==><a href="<?php echo "https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$app_id&state=$state&redirect_uri=$redrect_uri&scope=basic,netdisk&display=tv&qrcode=1&force_login=1";?>">授权链接</a></p>
            <p><b>提示：</b>手机打开时，请缩放网页以获取大小合适的二维码</p>
        <?php
            if(isset($display)){
                echo "<br>";
                echo "<h2>授权提示</h2>";
                echo "<p>授权成功后，将自动重定向至：".urldecode($display)."</p>";
            }else{
               if($_SESSION['result']){
                echo "<br>";
                echo "<h2>授权提示</h2>";
                echo "您已获取过授权，可点击查看上一次<a href='./display.php'>授权结果</a>";
                }
            }
        
        ?>
        </div>
        <footer class="copyright">
                <div class="navbar navbar-default navbar-inverse">
                <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo $config['site']['title'];?> <?php echo date('Y')?></p>
                </div>
        </footer>
        <style>
            .container{
                font-size: 1.2em;
            }
            .copyright,.navbar-inverse{
                margin-bottom: 0px;
            }
        </style>
        <script>
            let auto_login = `<?php echo $conn;?>`
            let force_ligin = `<?php echo $force_conn;?>`
            let force = document.getElementById("force")
            let link = document.getElementById("link")
            let changeNum = 1;
            force.onchange = function(){
                changeNum++;
                if(changeNum%2==0){
                    link.href = force_ligin
                }else{
                    link.href = auto_login
                }
            }
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