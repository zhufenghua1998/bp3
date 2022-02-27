<?php
    // 图片列表展示
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    
    force_login();
    
    $path = force_get_param("path");
    
    $path = urldecode($path);
    // 一次至多查找$num张
    $num = 1000;
    $encode_path = urlencode($path);
    
    $access_token = $config['identify']['access_token'];
    
    $url = "http://pan.baidu.com/rest/2.0/xpan/file?parent_path=$encode_path&access_token=$access_token&web=1&recursion=1&method=imagelist&num=$num";
    
    $opt = easy_build_http("GET",["User-Agent:pan.baidu.com"]);
    $result = easy_file_get_content($url,$opt);
    
    $json = json_decode($result);
    
    $info = $json->info;
    
    // easy_dump($info);
    
    $realNum = count($info);
    
    // 排序
    // easy_dump($info);
    
    
    echo "<h2>正在尝试获取该目录下的所有图片，本次最多提取 $num 张，本次取到：$realNum 张，仅显示png和jpg格式：</h2>";
    
    echo "<p><b>提示：</b>左键查看大图，右键下载高清原图...</p>";
    
    
    $current_date = "";
    
    foreach ($info as $info_i){
        $fileName = $info_i->server_filename;
        $file_end = substr($fileName, strrpos($fileName, '.')+1);
        if($file_end=="png"||$file_end=="PNG"||$file_end=="jpg"||$file_end=="JPG"||$file_end=="jpeg"||$file_end=="JPEG"){
            
            // 计算当前图片日期
            
            $img_date = date("Y 年 m 月 d 日",$info_i->server_ctime);
            
            // 新的一天
            if($current_date !=  $img_date){
                $current_date = $img_date;
                echo "<p>$current_date</p>";
            }
            
            $src = $info_i->thumbs->url3;
            $fs_id = $info_i->fs_id;
            echo "<div class='fileicon' fsid=$fs_id style='background-image: url(\"$src\");'></div>";
            
        }
    }
    

?>
<head>
    <title><?php echo "bp3相册 | $path";?></title>
</head>
<style>
.fileicon {
    width: 156px;
    height: 156px;
    display: inline-block;
    opacity: 1;
    background-position: center center;
    background-repeat: no-repeat;
    background-size:200px;
    margin: 0px 10px 10px 0px;
}
</style>
<script src="../js/jquery.min.js"></script>
<script>
    $(".fileicon").click(function(){
        let url = $(this).css("background-image").split('"')[1];
        window.open(url);
    });
    $(".fileicon").contextmenu(function(){
        let check = confirm("下载原图片？");
        if(check){
            let fsid = $(this).attr("fsid");
            location.href="../dn.php?fsid="+fsid;
        }
        return false;
    })
</script>