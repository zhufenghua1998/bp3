<?php

    session_start();
    // 提示：访问此页面时证明：本次从首页获取授权，而不是接口
    $_SESSION['display'] = "display";
    require_once("./config.php");
    require_once("./functions.php");
    
    // 1. 获取基础信息
    $app_id = $connect['app_id'];
    $redrect_uri = $connect['redirect_uri'];
    
    // 2. 拼接授权信息
    $state = rand(10,100);
    $_SESSION['state'] = $state;
    
    // 2.1自动检测链接
    $conn = "https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$app_id&redirect_uri=$redrect_uri&scope=basic,netdisk&display=popup&state=$state";
    // 2.2强制登录链接
    $force_conn = $conn.'&force_login=1';
    // 3. 点击下面的链接以获取token
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>bp3授权系统</title>
    </head>
    <body>
        <h2>这是<a href="..">bp3</a>的简易授权系统</h2>
        <?php
            if($_SESSION['result']){
                echo "<h2>提示：当前已经获取授权，查看最后一次<a href='./display.php'>授权结果</a></h2>";
            }
        
        ?>
        <h2>获取授权方式：手动获取</h2>
        <p>手动授权方式，是指手动点击授权，即可获取授权信息</p>
        <p><b>提示：</b>原始access_token必须通过手动获取</p>
        <p>点击右边的链接，然后获取授权
            》》<a id="link" href="<?php echo $conn;?>">跳转链接</a></p>
        <p><b>提示：</b>默认自动检测当前登录的百度账号，
        如果需要强制登录，请勾选<input id="force" type="checkbox"/><label for="force">强制登录</label></p>
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
        </script>
    </body>
</html>