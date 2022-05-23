<?php
/**
 * 普通用户帮助文档
 */
    require_once("../functions.php");
    force_login();

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
    <script src="../js/functions.js"></script>

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
    <p>当前版本号：<?php echo $version;?> 可点击 <button onclick="check_update()" class="btn btn-primary">检测更新</button></p>
    <p><b>提示：</b>请保持更新，或向我们提供新功能需求、建议，有概率采纳。</p>
    <p>值得一提的是：修复一个或几个bug，或许不会发布新版本。</p>
    <p><b>提示：</b>可以点击<a href="<?php echo $update_url ?>" target="_blank">最新下载地址</a>（设置项24）并下载最新版代码</p>
    <div id="latest_tip">
    </div>

    <h2>导入与导出</h2>
    <p>如果你希望导入最新版代码，可 <input type="button" class="btn btn-primary" value="导入压缩包" onclick="$('#upload').trigger('click');"/>，程序会自动更新</p>
    <p><b>导入格式：</b>导入代码时，该压缩包仅包含bp3-main文件夹，所有代码放在该文件夹下，github下载时默认该格式</p>
    <p class="hidden"><input id="upload" type="file" class="hidden"/></p>
      <div id="show_progress" class="progress-area hidden">
        进度
        <div class="progress">
          <div class="progress-bar" id="progress" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
        <div>
          <p id="time"></p>
        </div>
      </div>
    <p>如果需要下载站点中所有内容，可 <a class="btn btn-primary" style="text-indent:0px"  href="../controller/helpapi.php?method=backup">导出压缩包</a></p>
    <p><b>导出格式：</b>导出的压缩包中，仍包含一个子目录bp3-main，所有文件在该目录下。</p>
    <p>如果只是想导出配置文件，当然也是可以的，你可以选择<input id="upload_config" type="file" class="hidden"/><button class="btn btn-primary" onclick="$('#upload_config').trigger('click');">导入配置文件</button> 或 <button class="btn btn-primary" onclick="get_config()">导出配置文件</button></p>
    <h3>如何配置前台开放目录？</h3>
    <p>在设置中，写上要省略的前置目录，例如：</p>
    <ul>
        <li>开放根目录：留空</li>
        <li>开放/apps目录：填写/apps，注意结尾不要/</li>
    </ul>
    
    <h3>关于权限设置？</h3>
    <p>鉴于用户往往难以正确设置，我们最终决定开放大部分权限</p>
    <p>除了文件下载（严重浪费服务器、还可能花钱）等，其余功能默认全部开放</p>
    <p>此外，如你所愿，可以设置一个错误的前台路径，这样前台就是空的</p>
    
    <h3>如何重置系统？</h3>
    <p>一般来说，我们不推荐您这么做，除非真的坏掉了，或者在做测试。</p>
    <p>请把根目录下config.php文件删除，会重置本系统，也可以点击 <button class="btn btn-primary" onclick="reset_sys()">立即重置</button></p>
    <p>如果系统中缺少基础信息或需还原，可点击 <button class="btn btn-primary" onclick="reset_basic()">还原设置</button> ，可以恢复基础设置</p>
    
    <h3>账户已经锁定？</h3>
    <p>为防止暴力破解，一旦账户密码连续错误3次，将会锁定，暂需手动恢复</p>
    <p>请ftp后，编辑根目录下的config.php文件，把 user => chance 选项设置为3</p>
    <p>新：可绑定百度账户，该用户可直接登录，或解锁bp3账户</p>
    
    <h3>本系统授权服务器地址？</h3>
    <p>免app授权地址</p>
    <pre><code><?php echo $grant;?></code></pre>
    <p>内置app授权地址</p>
    <pre><code><?php echo $grant2;?></code></pre>
    <p><b>提示：</b>免app是默认配置系统，操作更简单，但需要配置回调信息，鉴于许多用户无法配置回调，最终内置了app授权系统</p>
    <p><b>提示：</b>内置app信息可以修改为您申请的app（推荐）</p>
    
    <h3>开发者获取token接口</h3>
    <p>bp3当前使用的access_token可以被其他程序获取，为了安全起见仅本机程序(同IP地址)可以获取，地址如下：</p>
    <pre><?php echo $open_url; ?></pre>
    <p>例如，你可以使用以下python代码获取access_token</p>
    <pre><code>from urllib import request
    
resp = request.urlopen('<?php echo $open_url;?>')
print(resp.read().decode())</code></pre>
    <p>如果你希望直接取得token用于测试，请<a href="../open.php" target="_blank">点击查看</a>。此外，强制刷新token的地址为<a target="_blank" href="refresh_token.php">admin/refresh_token.php</a></p>
    <h3>其他问题</h3>
    <p>可参阅文档：<a href="https://pan.baidu.com/union/doc/" target="_blank">百度网盘开发者官方文档</a>，或 <a href="https://www.52dixiaowo.com/post-3261.html" target="_blank">bp3简易使用手册</a></p>
    <p>如需帮助，请在github发布 <a href="https://github.com/zhufenghua1998/bp3/issues" target="_blank">issure</a>，或者QQ交流群：1150064636，了解我们最新动态</p>
    <p>当然，你也可以对bp3进行二次开发，或者申请定制服务？（群内咨询）</p>
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
    td{
        word-break: break-all;
    }
</style>
<script>
    var progress = document.querySelector('#progress');
    var time = document.querySelector('#time');
    var xhr = new XMLHttpRequest();
    var loaded = 0, ot = 0, total = 0, oloaded = 0 ;
    
    $(function () {
      if($(window).height()==$(document).height()){
        $(".copyright").addClass("navbar-fixed-bottom");
      }
      else{
        $(".copyright").removeClass(" navbar-fixed-bottom");
      }
      
	let file = document.getElementById('upload');
	file.onchange = function(){
        
        if(!file.files[0]) {
            return
        }
        let ext,idx;   
        let imgName = file.value;
        idx = imgName.lastIndexOf(".");   
        if (idx != -1){   
        ext = imgName.substr(idx+1).toUpperCase();   
        ext = ext.toLowerCase(); 
        // alert("ext="+ext);
        if (ext != 'zip'){
            alert("只能上传.zip 类型的文件!"); 
            return;  
        }
        }
        if(file.files[0].size>20971520) {
            alert('文件不得超过20M')
            return
        }
        var formData = new FormData();
        formData.append('file', file.files[0]);
        xhr.onload = uploadSuccess;
        xhr.upload.onprogress = setProgress;
        xhr.open('post', '../update/up_upload.php', true);
        xhr.send(formData);
	}
        // 成功上传
        function uploadSuccess(event) {
          if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            lazy_reload(2000);
          }
        }
        // 进度条
        function setProgress(event) {
          // event.total是需要传输的总字节，event.loaded是已经传输的字节。如果event.lengthComputable不为真，则event.total等于0
          if (event.lengthComputable) {//
              loaded = event.loaded
              total = event.total
              var complete = (event.loaded / event.total * 100).toFixed(1);
              progress.innerHTML = Math.round(complete) + "%";
              progress.style.width = complete + '%';
          }
          var time = document.getElementById("time");
          var nt = new Date().getTime();//获取当前时间
          var pertime = (nt-ot)/1000; //计算出上次调用该方法时到现在的时间差，单位为s
          ot = new Date().getTime(); //重新赋值时间，用于下次计算
          var perload = event.loaded - oloaded; //计算该分段上传的文件大小，单位b      
          oloaded = event.loaded;//重新赋值已上传文件大小，用以下次计算
          //上传速度计算
          var speed = perload/pertime;//单位b/s
          var bspeed = speed;
          var units = 'b/s';//单位名称
          if(speed/1024>1){
              speed = speed/1024;
              units = 'k/s';
          }
          if(speed/1024>1){
              speed = speed/1024;
              units = 'M/s';
          }
          speed = speed.toFixed(1);
          //剩余时间
          var resttime = ((event.total-event.loaded)/bspeed).toFixed(1);
          time.innerHTML = '传输速度：'+speed+units+'，剩余时间：'+resttime+'s';
          // if(bspeed==0) time.innerHTML = '上传已取消';
        }
        xhr.onloadstart = function(){
          console.log("上传开始");  
          $("#show_progress").removeClass("hidden");
        }
        xhr.ontimeout = function(){
          console.log('上传超时.');
        }
        // xhr.timeout = 50000; // 默认为0 没有时间限制
        // xhr.onabort = function(){
        //   console.log("The transfer has been canceled by the user.");
        // }
        xhr.onerror = function(){
          console.log("上传错误，可能是断网了，也可能是断请求服务了.");  // 这里存在异步传输问题
          return
        }
        xhr.onloadend = function(){
          console.log("请求结束"); // 发送上传的请求，至于有没有上传成功，不清楚，可能失败 成功，这里只是请求结束了
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
    
    /**
     * 检测更新
     */ 
    function check_update(){
        
        // 不可重复点击
        $(event.target).prop('disabled', true);
        // 发送ajax请求
        $.post("../update/up_check.php",function(data){
            
            let version = '<?php echo $version;?>';
            if(version >= data.tag_name){
                
                $("#latest_tip").empty();
                let str = "<p class='text-info'>恭喜，您当前已经是最新版啦！</p>";
                $("#latest_tip").append(str);
                return;
                
            }
            
            $("#latest_tip").empty();
            let str = `<table class="table table-bordered table-responsive">`;
            str += `<tr><td>最新版本</td><td>${data.tag_name}</td></tr>`;
            str += `<tr><td>版本类型</td><td>${data.prerelease?"测试版":"稳定版"}</td></tr>`;
            
            let version_body = data.body;
            version_body = version_body.replace(/\r\n/g,"<br>");
                
            let up_time = new Date(data.published_at);
            let time_str = up_time.format("YYYY-MM-DD HH:MM:SS"); 
            
            str += `<tr><td>版本描述：</td><td>${version_body}</td></tr>`
            str += `<tr><td>更新时间</td><td>${time_str}</td></tr>`
            str += `<tr><td>更新方式</td><td><button class="btn btn-primary" onclick="auto_update()">自动更新</button></td></tr>`;
            str += `<tr><td>更新说明</td><td>如果刚检测到新版，请等待半小时后再更新，我们可能正在上传新代码<br>如果想提高成功率：①选择合适的更新源，②下载后手动上传</td></tr>`;
            str += `</table>`;
            $("#latest_tip").append(str);
        },"json");
    }
    
    /**
     * 自动更新
     */ 
    function auto_update(){
        let check = confirm("后台更新时不要乱动");
        if(check){
            $.post("../update/up_fast.php",{},function(data){
                alert(data);
                lazy_reload(2000);
            });
        }else{
            message("取消自动更新","info");
        }
    }
    
    /**
     * 重置系统
     */ 
    function reset_sys(){
        let check = confirm("确定要重置系统吗？");
        if(check){
            $.post("../controller/helpapi.php?method=resetsys",function(data){
                if(data.errno==0){
                    alert("重置成功，即将重新配置！");
                    location.href = "..";
                }
            },"json")
        }else{
            message("重置系统取消","info");
        }
    }
    
    /**
     * 导出config文件
    */
    function get_config(){
        location.href = "../controller/helpapi.php?method=getconfig";
    }
    
    /**
     * 导入配置文件
     */
    $("#upload_config").change(function(){
        
        let check = confirm("这会覆盖配置文件，已再次确认？");
        if(!check){
            this.value = "";
            return;
        }
        if(!this.files[0]) {
            this.value = "";
            return;
        }
        let ext,idx;   
        let imgName = this.value;
        idx = imgName.lastIndexOf(".");   
        if (idx != -1){   
        ext = imgName.substr(idx+1).toUpperCase();   
        ext = ext.toLowerCase(); 
        // alert("ext="+ext);
        if (ext != 'php'){
            alert("只能上传.php 类型的文件!"); 
            this.value="";
            return;  
        }
        }
        if(this.files[0].size>20971520) {
            alert('文件不得超过20M')
            this.value = "";
            return
        }
        let formData = new FormData();
        formData.append('file', this.files[0]);
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4 && xhr.status == 200)
            {
                if(this.responseText){
                    let jsonObj = JSON.parse(this.responseText);
                    if(jsonObj.errno==0){
                        message("导入成功","success");
                    }else{
                        message("导入失败","error");
                    }
                }else{
                    message("导入失败","error");
                }
            }
        }
        xhr.open('post', '../controller/helpapi.php?method=setconfig', true);
        xhr.send(formData);
	})
	
	// 还原设置
	function reset_basic(){
        let check = confirm("确定要还原默认设置吗？（很安全）");
        if(check){
            $.post("../controller/helpapi.php?method=resetbasic",function(data){
                if(data.errno==0){
                    alert("还原成功，请重新查看设置！");
                }
            },"json")
        }else{
            message("还原设置取消","info");
        }
	}
	
    Date.prototype.format = function (fmt) {
      var o = {
        "M+": this.getMonth() + 1,                   //月份
        "d+": this.getDate(),                        //日
        "h+": this.getHours(),                       //小时
        "m+": this.getMinutes(),                     //分
        "s+": this.getSeconds(),                     //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds()                  //毫秒
      };
    
      //  获取年份 
      if (/(y+)/i.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
      }
    
      for (var k in o) {
        if (new RegExp("(" + k + ")", "i").test(fmt)) {
          fmt = fmt.replace(
            RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        }
      }
      return fmt;
    }

</script>
</body>
</html>