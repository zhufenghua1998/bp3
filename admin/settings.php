<?php
    // 设置页面
    session_start();
    $user = $_SESSION['user'];
    $config_file = "../config.php";
    require($config_file);
    require_once("../functions.php");
    
    force_login();
    
    if(!$_POST['s1']){ // 抓取一个必要数据，捕获为空，说明未提交
        // 正常返回页面
    }else{
        // 保存数据
        $config['site']['title'] = $_POST['s1'];
        $config['site']['subtitle'] = $_POST['s2'];
        $config['user']['name'] = $_POST['s3'];
        $config['user']['pwd'] = $_POST['s4'];
        $config['user']['lock'] = $_POST['s5'];
        $config['connect']['app_id'] = $_POST['s6'];
        $config['connect']['secret_key'] = $_POST['s7'];
        $config['connect']['redirect_uri'] = $_POST['s8'];
        $config['control']['pre_dir'] = $_POST['s9'];
        $config['site']['blog'] = $_POST['s10'];
        $config['site']['github'] = $_POST['s11'];
        $config['baidu']['baidu_account'] = $_POST['s12'];
        $config['baidu']['baidu_pwd'] = $_POST['s13'];
        $config['control']['pre_link'] = $_POST['s14'];
        $config['control']['close_dload'] = $_POST['s15'];
        $config['control']['open_grant'] = $_POST['s16'];
        $config['identify']['grant_url'] = $_POST['s17'];
        $text='<?php $config='.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
        echo "<script>alert('保存成功')</script>";
    }

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>修改设置 | bp3</title>
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
          <a class="navbar-brand" href="./">管理系统</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav">
            <li><a href="./file.php">文件管理<i class="fa fa-th-large" aria-hidden="true"></i><span class="sr-only">(current)</span></a></li>
            <li class="active"><a href="./settings.php">修改设置<i class="fa fa-cog"></i></a></li>
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
<div class="container">
<form method="post">
<div class="bs-example" data-example-id="contextual-table">
    <div class="row">
        <div class="col-xs-6">
            <h4 class="text-danger">请谨慎修改设置</h4>
        </div>
        <div class="col-xs-6 text-right">
           <button class="btn btn-default" type="submit">保存设置</button>
        </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th></th>
          <th>属性名</th>
          <th>旧数据</th>
          <th>新数据</th>
        </tr>
      </thead>
      <tbody>
        <tr class="active">
          <th scope="row">1</th>
          <td>网站名称</td>
          <td class="br"><?php echo $config['site']['title'];?></td>
          <td><input name="s1" value="<?php echo $config['site']['title'];?>" class="form-control"/></td>
        </tr>
        <tr scope="row">
          <th scope="row">2</th>
          <td>网站副标题</td>
          <td class="br"><?php echo $config['site']['subtitle'];?></td>
          <td><input name="s2" value="<?php echo $config['site']['subtitle'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">3</th>
          <td>用户名</td>
          <td class="br"><?php echo $config['user']['name'];?></td>
          <td><input name="s3" value="<?php echo $config['user']['name'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">4</th>
          <td>用户密码</td>
          <td class="br"><?php echo $config['user']['pwd'];?></td>
          <td><input name="s4" value="<?php echo $config['user']['pwd'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">5</th>
          <td>账户锁定</td>
          <td class="br"><?php echo $config['user']['lock'];?></td>
          <td><input name="s5" value="<?php echo $config['user']['lock'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">6</th>
          <td>app_id</td>
          <td class="br"><?php echo $config['connect']['app_id'];?></td>
          <td><input name="s6" value="<?php echo $config['connect']['app_id'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">7</th>
          <td>secret_key</td>
          <td class="br"><?php echo $config['connect']['secret_key'];?></td>
          <td><input name="s7" value="<?php echo $config['connect']['secret_key'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">8</th>
          <td>redirect_uri</td>
          <td class="br"><?php echo $config['connect']['redirect_uri'];?></td>
          <td><input name="s8" value="<?php echo $config['connect']['redirect_uri'];?>" class="form-control"  placeholder="admin/connect.php"/></td>
        </tr>
        <tr class="active">
          <th scope="row">9</th>
          <td>前台路径</td>
          <td class="br"><?php echo $config['control']['pre_dir'];?></td>
          <td><input name="s9" value="<?php echo $config['control']['pre_dir'];?>" class="form-control" placeholder="根目录留空即可"/></td>
        </tr>
        <tr>
          <th scope="row">10</th>
          <td>官博地址</td>
          <td class="br"><?php echo $config['site']['blog'];?></td>
          <td><input name="s10" value="<?php echo $config['site']['blog'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">11</th>
          <td>github地址</td>
          <td class="br"><?php echo $config['site']['github'];?></td>
          <td><input name="s11" value="<?php echo $config['site']['github'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">12</th>
          <td>baidu账号</td>
          <td class="br"><?php echo $config['baidu']['baidu_account'];?></td>
          <td><input name="s12" value="<?php echo $config['baidu']['baidu_account'];?>" class="form-control" /></td>
        </tr>
        <tr class="active">
          <th scope="row">13</th>
          <td>baidu密码</td>
          <td><?php echo $config['baidu']['baidu_pwd'];?></td>
          <td><input name="s13" value="<?php echo $config['baidu']['baidu_pwd'];?>" class="form-control" /></td>
        </tr>
        <tr>
          <th scope="row">14</th>
          <td>关闭直链</td>
          <td><?php echo $config['control']['pre_link'] ?></td>
          <td><input name="s14" value="<?php echo $config['control']['pre_link'] ?>" class="form-control" placeholder="填写1或0(默认)" /></td>
        </tr>
        <tr class="active">
         <th scope="row">15</th>
          <td>关闭下载</td>
          <td><?php echo $config['control']['close_dload'] ?></td>
          <td><input name="s15" value="<?php echo $config['control']['close_dload'] ?>" class="form-control" placeholder="填写1或0(默认)" /></td> 
        </tr>
        <tr>
            <th scope="row">16</th>
            <td>open_grant</td>
            <td><?php echo $config['control']['open_grant'] ?></td>
            <td><input name="s16" value="<?php echo $config['control']['open_grant'] ?>" class="form-control" placeholder="填写1或0(默认)" /></td>
        </tr>
        <tr class="active">
         <th scope="row">17</th>
          <td>授权地址</td>
          <td><?php echo $config['identify']['grant_url'] ?></td>
          <td><input name="s17" value="<?php echo $config['identify']['grant_url'] ?>" class="form-control" placeholder="修改后请重新授权" /></td> 
        </tr>
      </tbody>
    </table>
  </div>
</form>
</div>
</main>
<footer class="navbar navbar-default navbar-inverse copyright">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © bp3 <?php echo date('Y')?></p>
</footer>
<style>
    .copyright{
        margin-bottom: 0px;
    }
    .br,td{
        word-break: break-all !important;
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
    if(document.body.clientWidth<768){
        $(".m-btns").addClass("btn-group-vertical");
    }
    });
</script>
</body>
</html>