<?php
    // 设置页面
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    
    force_login();
    
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
<form id="main_form" method="post">
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
          <td>网站名称 <span class="tip fa fa-question-circle-o"  tip="用于网站主标题"></span></td>
          <td class="br"><?php echo $config['site']['title'];?></td>
          <td><input name="s1" value="<?php echo $config['site']['title'];?>" class="form-control"/></td>
        </tr>
        <tr scope="row">
          <th scope="row">2</th>
          <td>网站副标题 <span class="tip fa fa-question-circle-o"  tip="用于网站副标题"></span></td>
          <td class="br"><?php echo $config['site']['subtitle'];?></td>
          <td><input name="s2" value="<?php echo $config['site']['subtitle'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">3</th>
          <td>用户名 <span class="tip fa fa-question-circle-o"  tip="用于登录bp3的用户名"></span></td>
          <td class="br"><?php echo $config['user']['name'];?></td>
          <td><input name="s3" value="<?php echo $config['user']['name'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">4</th>
          <td>用户密码 <span class="tip fa fa-question-circle-o"  tip="用于登录bp3的密码"></span></td>
          <td class="br"><?php echo $config['user']['pwd'];?></td>
          <td><input name="s4" value="<?php echo $config['user']['pwd'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">5</th>
          <td>账户锁定 <span class="tip fa fa-question-circle-o"  tip="连续登录错误账户锁定次数"></span></td>
          <td class="br"><?php echo $config['user']['lock'];?></td>
          <td><input name="s5" value="<?php echo $config['user']['lock'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">6</th>
          <td>app_id <span class="tip fa fa-question-circle-o"  tip="配置百度app的appKey"></span></td>
          <td class="br"><?php echo $config['connect']['app_id'];?></td>
          <td><input name="s6" value="<?php echo $config['connect']['app_id'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">7</th>
          <td>secret_key <span class="tip fa fa-question-circle-o"  tip="用于配置百度app的secretKey"></span></td>
          <td class="br"><?php echo $config['connect']['secret_key'];?></td>
          <td><input name="s7" value="<?php echo $config['connect']['secret_key'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">8</th>
          <td>redirect_uri <span class="tip fa fa-question-circle-o"  tip="用于配置百度app的回调地址"></span></td>
          <td class="br"><?php echo $config['connect']['redirect_uri'];?></td>
          <td><input name="s8" value="<?php echo $config['connect']['redirect_uri'];?>" class="form-control"  placeholder="grant/callback.php"/></td>
        </tr>
        <tr class="active">
          <th scope="row">9</th>
          <td>前台路径 <span class="tip fa fa-question-circle-o"  tip="开放给访客的目录"></span></td>
          <td class="br"><?php echo $config['control']['pre_dir'];?></td>
          <td><input name="s9" value="<?php echo $config['control']['pre_dir'];?>" class="form-control" placeholder="根目录留空即可"/></td>
        </tr>
        <tr>
          <th scope="row">10</th>
          <td>官博地址 <span class="tip fa fa-question-circle-o"  tip="可忽略，链接到你的博客网站"></span></td>
          <td class="br"><?php echo $config['site']['blog'];?></td>
          <td><input name="s10" value="<?php echo $config['site']['blog'];?>" class="form-control"/></td>
        </tr>
        <tr class="active">
          <th scope="row">11</th>
          <td>github地址 <span class="tip fa fa-question-circle-o"  tip="可忽略，链接到你的github"></span></td>
          <td class="br"><?php echo $config['site']['github'];?></td>
          <td><input name="s11" value="<?php echo $config['site']['github'];?>" class="form-control"/></td>
        </tr>
        <tr>
          <th scope="row">12</th>
          <td>baidu账号 <span class="tip fa fa-question-circle-o"  tip="可忽略，用于记录你的百度账号"></span></td>
          <td class="br"><?php echo $config['baidu']['baidu_account'];?></td>
          <td><input name="s12" value="<?php echo $config['baidu']['baidu_account'];?>" class="form-control" /></td>
        </tr>
        <tr class="active">
          <th scope="row">13</th>
          <td>baidu密码 <span class="tip fa fa-question-circle-o"  tip="可忽略，用于记录你的百度密码"></span></td>
          <td><?php echo $config['baidu']['baidu_pwd'];?></td>
          <td><input name="s13" value="<?php echo $config['baidu']['baidu_pwd'];?>" class="form-control" /></td>
        </tr>
        <tr>
          <th scope="row">14</th>
          <td>访客直链 <span class="tip fa fa-question-circle-o"  tip="关闭后，访客不可使用直链功能"></span>
          <td></td>
          <td>
                <label class="radio-inline">
                  <input <?php echo $config['control']['close_dlink']==0?"checked":"" ?> type="radio" name="s14" value="0"> 打开
                </label>
                <label class="radio-inline">
                  <input <?php echo $config['control']['close_dlink']==1?"checked":"" ?> type="radio" name="s14" value="1"> 关闭
                </label>
          </td>
        </tr>
        <tr class="active">
         <th scope="row">15</th>
          <td>访客下载 <span class="tip fa fa-question-circle-o"  tip="关闭后，访客不可直接下载"></span></td>
          <td></td>
          <td>
                <label class="radio-inline">
                  <input <?php echo $config['control']['close_dload']==0?"checked":"" ?> type="radio" name="s15" value="0"> 打开
                </label>
                <label class="radio-inline">
                  <input <?php echo $config['control']['close_dload']==1?"checked":"" ?> type="radio" name="s15" value="1"> 关闭
                </label>              
          </td>
        </tr>
        <tr>
            <th scope="row">16</th>
            <td>免app授权系统 <span class="tip fa fa-question-circle-o"  tip="打开后，本系统的免app授权地址可被访客使用"></span></td>
            <td></td>
            <td>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_grant']==1?"checked":"" ?> type="radio" name="s16" value="1"> 打开
                </label>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_grant']==0?"checked":"" ?> type="radio" name="s16" value="0"> 关闭
                </label>              
            </td>
        </tr>
        <tr class="active">
         <th scope="row">17</th>
          <td>授权地址 <span class="tip fa fa-question-circle-o"  tip="设置本站点使用的授权地址"></span></td>
          <td><?php echo $config['identify']['grant_url'] ?></td>
          <td><input name="s17" value="<?php echo $config['identify']['grant_url'] ?>" class="form-control" placeholder="修改后请重新授权" /></td> 
        </tr>
        <tr>
            <th scope="row">18</th>
            <td>内置app授权系统 <span class="tip fa fa-question-circle-o"  tip="打开后，访客可使用本系统的内置app授权系统"></span></td>
            <td></td>
            <td>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_grant2']==1?"checked":"" ?> type="radio" name="s18" value="1"> 打开
                </label>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_grant2']==0?"checked":"" ?> type="radio" name="s18" value="0"> 关闭
                </label>              
            </td>        
        </tr>
        <tr class="active">
         <th scope="row">19</th>
          <td>免部署解析 <span class="tip fa fa-question-circle-o"  tip="打开后，访客可使用bp3免部署版"></span></td>
            <td></td>
            <td>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_session']==1?"checked":"" ?> type="radio" name="s19" value="1"> 打开
                </label>
                <label class="radio-inline">
                  <input <?php echo $config['control']['open_session']==0?"checked":"" ?> type="radio" name="s19" value="0"> 关闭
                </label>              
            </td>        
        </tr>
        <tr>
         <th scope="row">20</th>
          <td>seo描述 <span class="tip fa fa-question-circle-o"  tip="对应于seo优化的description"></span></td>
            <td colspan="2">
                <input name="s20" class="form-control" value="<?php echo $config['site']['description'];?>"/>       
            </td>        
        </tr>
        <tr class="active">
         <th scope="row">21</th>
          <td>seo关键字 <span class="tip fa fa-question-circle-o"  tip="对应于seo优化的keywords"></span></td>
            <td colspan="2">
                <input name="s21" class="form-control" value="<?php echo $config['site']['keywords'];?>"/>       
            </td>        
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
    .checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline{
        margin: 0px;
        padding-right: 10px;
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
    
    $("#main_form").submit(function(){
        
        $.post("../controller/save_settings.php",$(this).serialize(),function(data){
            if(data.errno==0){
                alert("保存成功");
                location.reload();
            }else{
                alert("保存失败");
            }
        },"json");
        
        return false;
    });
    // 提示设置详情
    $(".tip").click(function(){
        alert($(this).attr("tip"));
    });
</script>
</body>
</html>