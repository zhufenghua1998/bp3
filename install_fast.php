<?php
    // 快速配置
    require_once("./functions.php");

    $config = $base;

    $param = $_GET['param']; //取得的安装信息

    $identify = null; //身份信息
    
    // 补全callback.php信息
    $redirect = $dir_url.'/grant/callback.php';

    // 如果未安装，且接收到了参数，开始安装
    if(!$install && !empty($param)){
        
        $config['user']['name']='bp3';
        $config['user']['pwd']='bp3';

        $config['connect']['redirect_uri']=$redirect;

        $param = urldecode($param); // 这是一个转码后的字符串，先转码，再转数组
        $identify = json_decode($param,true);

        $identify['conn_time'] = $time; // 使用外部系统可能比较旧缺少此项，在这里重新添加一次

        $config['identify'] = $identify;

        // 先保存config
        save_config();
    
        // 获取basic
        $basic = m_basic($identify['access_token']);
        
        $config['basic'] = $basic;
        
        // 保存config
        save_config();
        redirect($login_url,0);
    }else if(!empty($param)){
        // 请求初始化，但已经初始化了
        js_alert("你已经配置过了，如果需要重新配置，请把config.php文件删掉");
        js_location($login_url);
    }
    
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>bp3 | 免app安装</title>
        <link href="./favicon.ico" rel="shortcut icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./css/bootstrap.min.css" rel="stylesheet">
        <script src="./js/jquery.min.js"></script>
        <script src="./js/bootstrap.min.js"></script>
        <link href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <style>
            body{
                background-color: #f0f0f1;
            }
            .container{
                background-color: #fff;
                margin: 100px auto;
                font-size: 1.2em;
            }
            .container > p{
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h3 class="text-center">欢迎使用bp3，正在体验免app配置</h3>
            <p>免app配置时，默认<span class="text-danger">账户密码均为bp3</span></p>
            <p>如果本次配置未能成功，请把config.php删掉并重新访问本页面</p>
            <form class="form-inline">
            <div class="form-group">
                <input class="form-control" id="customGrant" placeholder="自定义授权系统地址"/>
            </div>
            <button type="button"  onclick="customGrantFun()" class="btn btn-primary">确定</button>
            </form>
            <p><b>提示：</b>自定义授权系统，安全性请自己鉴别。</p>
            <p>或从以下列表中选取一个快速授权地址，并访问：</p>
            <ol>
                <li><a href="https://bp3.52dixiaowo.com/grant/?display=<?php echo $enc_page_url;?>">bp3官方(国内)</a></li>
                <li><a href="http://bp3.rbusoft.com/grant/?display=<?php echo $enc_page_url;?>">阿布软件网(海外)</a></li>
            </ol>
            <p>任意点击上面在一个地址，进行账户授权，即可自动完成</p>
            <p><b>提示：</b>如果上述地址均不可用，请手动获取授权原始信息，并粘贴到下面：</p>
            <form method="get">
                <textarea name="param" rows="4" cols="30" placeholder="请粘贴授权原始信息"></textarea>
                <p><input class="btn btn-primary" type="submit" value="提交"></p>
            </form>
            <p><b>提示：</b>安装完毕后，可在后台调整配置app，或者免app授权，以及内置app三种授权方式。</p>
            <p><b>提示：</b>如果安装遇到问题，可在github求助，或QQ交流群：1150064636。</p>
            <p><a href="./install.php">返回配置app授权</a> 或 <a href="./install_inner.php">初始化内置app授权</a></p>
        </div>
        <script>
            function customGrantFun(){
                location.href = ''+$("#customGrant").val()+"?display=<?php echo $enc_page_url;?>";
            }
        </script>
    </body>
</html>
