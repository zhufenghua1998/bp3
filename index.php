<?php
    require('./functions.php');

    if($check_login){
        $action = '管理';
    }else{
        $action = '登录';
    }

    // 捕获dir查询参数
    $dir = $_GET['dir']; // 少了前缀
    $real_dir = "";  // 真实路径
    // 捕获查询参数
    $key = $_GET['s'];
    // 捕获分页参数
    $page = empty($_GET['page'])? 1 : $_GET['page'];
    // data数据，优先查询，然后是dir
    $data = null;
    if(isset($key)){
        $data = m_file_search($pre_dir,$page,$key,$access_token);
    }else{
        //处理前台路径
        if(!$dir){ // 访问网页首页
            if($pre_dir==""){
                $dir = "/";
                $real_dir="/";
            }else{
                $real_dir = $pre_dir;
            }
        }else{
            $real_dir = $pre_dir.$dir;
        }
        $data = m_file_list($real_dir,$access_token);
    }
    // 是否还有下一页(仅搜索接口）
    $has_more = $data['has_more'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title.' | '.$subtitle;?></title>
    <meta name="description"
      content="<?php echo $description;?>" />
    <meta name="keywords"
      content="<?php echo $keywords; ?>" />
 
    <link href="./favicon.ico" rel="shortcut icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link href="./fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
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
          <a class="navbar-brand" href="./"><?php echo $title;?></a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
            <li class="active"><a href="./">首页<i class="fa fa-home"></i></a></li>
          </ul>
          <form class="navbar-form navbar-left" action="./">
            <div class="form-group">
              <input type="text" name="s" required="required" class="form-control" placeholder="搜索文件">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./login.php"><?php echo $action;?><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $blog;?>">官博<i class="fa fa-rss"></i></a></li>
            <li><a href="<?php echo $github;?>">github<i class="fa fa-github" aria-hidden="true"></i></a></li>
            <li><a href="./user/login.php">免部署版<i class="fa fa-info-circle" aria-hidden="true"></i></a></li>
         </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div id="myheader" class="container-fluid">
        <div class="container jumbotron">
            <div class="row">
                <p class="text-center"><?php echo $title.' - '.$subtitle;?></p>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <ol class="breadcrumb">
             <?php
                echo "<li><a href='./'>Home</a></li>";
                if($dir!=""){ // 非根目录，一个或多个
                    $dirs = explode('/',$dir); // 取得路径
                    $dir_path = '';  // 新的访问路径
                    $dir_paths = [null,]; // 存储新路径组
                    for($i=1;$i<count($dirs);$i++){
                        $dir_path.='/';
                        $dir_path.=$dirs[$i];
                        $dir_paths[$i] = $dir_path;
                        $dir_link = urlencode($dir_path);
                        echo "<li><a href='?dir=$dir_link'>$dirs[$i]</a></li>";
                    }
                }
            ?>
                    </ol>
                </div>
            </div>
            <form>
                <div class="row">
                    <div class="col-xs-12">
                    <div class="search-wraper" role="search">
                        <div class="input-group">
                          <input type="text" name="s" class="form-control" placeholder="<?php if($key) echo '正在搜索：'.$key; else echo '搜索文件';?>" required="required">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                        </div><!-- /input-group -->
                    </div>
                    </div><!--col-xs-12-->
              </div><!--row-->
            </form>
            </div>
        </div>
    </div>
    </header>
 <main>
    <div class="container">
    <table class="table table-bordered table-responsive">
<?php
    // 获取查询方式，调用查询方法，优先query，参数s
    if($key){ // 在正搜索

        if(!$data['list']){
            echo("这儿似乎什么也没有...");
        }else{
            echo "<thead class='active'><tr><th></th><th>文件<i class='glyphicon glyphicon-chevron-down'></i></th><th>大小<i class='glyphicon glyphicon-chevron-down'></i></th><th>下载<i class='glyphicon glyphicon-chevron-down'></i></th></tr></thead><tbody>";

            foreach ($data['list'] as $row){
                if($row['isdir']==1){
                    // 去掉前缀，且编码
                    $path = substr($row['path'],strlen($pre_dir));
                    $encode_path = urlencode($path);
                    echo "<tr><th scope='row'><i class='glyphicon glyphicon-folder-open'></i></th><td class='info' colspan='3' ><a href='?dir=$encode_path' style='display:block'>$path</a></td></tr>";
                 }else{
                    // 取得文件id
                    $fsid = $row['fs_id'];
                    // 显示大小
                    $show_size = height_show_size($row['size']);
                    // 去掉前缀的title
                    $title = substr($row['path'],strlen($pre_dir));
                    //是否前台直链
                    $pre_dlink = "";
                    if($close_dlink==0  || !check_session()){
                        $pre_dlink = "<a target='_blank' href='$dlink_url?fsid=$fsid' type='button' class='btn btn-default'>直链</a><a class='btn btn-default cp2' data-clipboard-text='$dlink_url?fsid=$fsid'>复制</a>";
                    }
                    // 是否前台下载
                    $dn="";
                    if($close_dload==0 && !check_session()){
                        $dn = "<a href='$dn_url?fsid=$fsid' type='button' class='btn btn-default'>下载</a><button type='button' class='btn btn-default cp' data-clipboard-text='$dn_url?fsid=$fsid'>复制</button>";
                    }
                    // 文件名
                    $server_filename = $row['server_filename'];
                    echo ("<tr><th scope='row'><i class='glyphicon glyphicon-file'></i></th>
                         <td>$server_filename<span tip='$title' class='tip fa fa-question-circle-o'></span></td><td>$show_size</td>
                          <td>
                              <div class='m-btns btn-group' role='group' aria-label='...'>
                              $dn $pre_dlink
                              </div>
                          </td>
                          </tr>");
                }
            }
            echo "</tbody>";
        }
    }
    else{ // dir查询

        if(!$data['list']){
            echo("这儿似乎什么也没有...");
        }else{
            echo "<thead><tr class='active'><th></th><th>文件<i class='glyphicon glyphicon-chevron-down'></i></th><th>大小<i class='glyphicon glyphicon-chevron-down'></i></th><th>下载<i class='glyphicon glyphicon-chevron-down'></i></th></tr></thead><tbody>";
            // var_dump($json);
            foreach ($data['list'] as $row){
                if($row['isdir']==1){
                    // 去掉前缀
                    $path = substr($row['path'],strlen($pre_dir));
                    $encode_path = urlencode($path);
                    $server_filename = $row['server_filename'];
                    echo "<tr><th scope='row'><i class='glyphicon glyphicon-folder-open'></i></th><td class='info' colspan='3' ><a href='?dir=$encode_path' style='display:block'>$server_filename</a></td></tr>";
                 }else{
                     $fsid = $row['fs_id'];
                     $show_size = height_show_size($row['size']);
                    //是否前台直链
                    $pre_dlink = "";
                    if($close_dlink==0 || check_session()){
                        $pre_dlink = "<a target='_blank' href='$dlink_url?fsid=$fsid' type='button' class='btn btn-default'>直链</a><a class='btn btn-default cp2' data-clipboard-text='$dlink_url?fsid=$fsid'>复制</a>";
                    }
                    $dn = "";
                    if($close_dload==0 || check_session()){
                        $dn = "<a type='button' class='btn btn-default' href='$dn_url?fsid=$fsid'>下载</a>
                            <button type='button' class='btn btn-default cp' data-clipboard-text='$dn_url?fsid=$fsid'>复制</button>";
                    }
                    $server_filename = $row['server_filename'];
                    echo "<tr><th scope='row'><i class='glyphicon glyphicon-file'></i></th>
                         <td class='br'>$server_filename</td><td>$show_size</td>
                         <td>
                             <div class='m-btns btn-group' role='group' aria-label='...'>
                             $dn $pre_dlink
                             </div>
                         </td>
                         </tr>";
                }
            }
            echo "</tbody>";
        }
    }
?>
    </table>

<?php  // 查询时存在分页
    if($key){
        if($page>1 || $has_more){
            $prev_page = $page-1;
            $next_page = $page+1;
            echo "<ul class='pager'>";
            if($page>1){
                echo "<li><a href='./?page=$prev_page&s=$key'>上一页</a></li>";
            }
            echo "<li><a>分页$page</a></li>";
            if($has_more){
                echo "<li><a href='./?page=$next_page&s=$key'>下一页</a></li>";
                echo "</ul>";
            }
        }
    }
?>
</div>
</main>

<footer class="copyright">
        <div class="navbar navbar-default navbar-inverse">
        <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo $config['site']['title'];?> <?php echo date('Y')?></p>
        </div>
</footer>
<a href="javascript:(function(){window.scrollTo(0, 0);})();" title="返回顶部" id="back-to-top" style="display:none;position:fixed;right:10px;bottom:10px;background-color:rgb(95,99,104);box-sizing: border-box;cursor:pointer;text-align:center;"><i class="fa fa-angle-up" style="height:40px;width:40px;display:iniline—block;line-height:40px;color:#fff;"></i></a>
<style>
   .br{
       word-break: break-all;
   }
   .jumbotron{
       margin-bottom: 0px;
   }
    main{
        margin-bottom: 20px;
    }
    .copyright,.navbar-inverse{
        margin-bottom: 0px;
    }
    .tip{
        cursor: pointer;
    }
</style>
<script src="./js/clipboard.min.js"></script>
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
    var btns = document.querySelectorAll('.cp');
    var clipboard = new ClipboardJS(btns);
    clipboard.on('success', function(e) {
        alert("下载链接复制成功");
    });
    clipboard.on('error', function(e) {
        alert("下载链接复制失败");
    });
    var btns2 = document.querySelectorAll('.cp2');
    var clipboard2 = new ClipboardJS(btns2);
    clipboard2.on('success', function(e) {
        alert("直链获取地址复制成功");
    });
    clipboard2.on('error', function(e) {
        alert("直链获取地址复制失败");
    });
    $(window).scroll(function(){
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if(scrollTop>50){
            $("#back-to-top").css("display","block");
        }else{
            $("#back-to-top").css("display","none");
        }
    });
    // 提示完整目录
    $(".tip").click(function(){
        alert($(this).attr("tip"));
    });
</script>
</body>
</html>