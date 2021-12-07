<?php
    session_start();
    $user = $_SESSION['user'];
    if(!$user){
        echo '您还未登陆。';
        die;  // 终止后续解析
    }
    require('../config.php');
    // 拼接refresh_token路径
    $page_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
    $page_url = str_replace("/index.php","",$page_url);
    $redirecturl = urlencode($page_url);
    $refresh_token = $page_url.'/refresh_token.php'; // end
    // 拼接授权地址
    $app_id = $config['connect']['app_id'];
    $redrect_uri = $config['connect']['redirect_uri'];
    $state = rand(10,100);
    $_SESSION['state'] = $state;
    $conn = "https://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=$app_id&redirect_uri=$redrect_uri&scope=basic,netdisk&display=popup&state=$state";
    $force_conn = $conn.'&force_login=1';
    // 判断网盘会员类型
    $vip_type = $config['basic']['vip_type'];
    if(isset($vip_type)){
        if($vip_type==2){
            $vip_type = '超级会员';
        }
        elseif($vip_type==1){
            $vip_type = '普通会员';
        }
        elseif($vip_type==0){
            $vip_type = '普通用户';
        }
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 | bp3</title>
    <link href="../favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery.min.js"></script>
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
          <a class="navbar-brand manager" href="./">管理系统</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav">
            <li class=""><a href="./file.php">文件管理<i class="fa fa-th-large" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
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
 <main  >
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h2>连接说明</h2>
            </div>
            <div class="col-xs-6">
                <h2><a id="link"  href="<?php echo $conn;?>">获取授权</a></h2>
            </div>
        </div>
        <div>
        <p>本程序需要连接到百度网盘。</p>
        <p>如果您是首次配置，请点击<b>获取授权</b>（免app配置时无须此项操作），登录百度账号以完成授权</p>
        <p>每次访问首页时，默认自动检测token有效期自动刷新，如果你的网站流量较少，请至少保证20天抓取一次首页。</p>
        <p><b>注意：</b>授权时，必须允许访问网盘数据，否则无法正常使用。</p>
        <p>如果你的浏览器已经登录百度，会自动检测百度cookie并尝试自动授权。你可以选择 <input id="force" type="checkbox"/><label for="force">强制登录</label></p>
        <p>在完成授权后，在下方会自动获取你的百度基础信息。</p>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h2>百度信息</h2>
            </div>
        </div>
        
        <div class="bs-example" data-example-id="bordered-table">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th></th>
                  <th>项目</th>
                  <th>数据</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>百度名称</td>
                  <td><?php echo $config['basic']['baidu_name'];?></td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>网盘昵称</td>
                  <td><?php echo $config['basic']['netdisk_name'];?></td>
                </tr>
                <tr>
                  <th scope="row">3</th>
                  <td>百度id</td>
                  <td><?php echo $config['basic']['uk'];?></td>
                </tr>
                <tr>
                  <th scope="row">4</th>
                  <td>网盘会员</td>
                  <td><?php echo $vip_type;?></td>
                </tr>
              </tbody>
            </table>
          </div><!-- table-example -->
          <p>注意：不要泄露你的access_token，以免带来不必要的麻烦。</p>
    </div>
</main>
<footer class="navbar navbar-default navbar-inverse copyright">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © bp3 <?php echo date('Y')?></p>
</footer>
<style>
    .manager{background-color:#e7e7e7;}
    .copyright{
        margin-bottom: 0px;
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