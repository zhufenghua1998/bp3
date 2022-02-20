<?php
    session_start();
    $config = require("../config.php");
    require_once("../functions.php");

    $access_token = $config['identify']['access_token'];

    force_login();  // 强制登录
    $base_dir = force_get_param("base_dir");
    
    if($base_dir=="/"){
        echo "不支持根目录";
        die;
    }
    $base_dir = urldecode($base_dir);
    // 一次至多查找1000条
    $limit = 1000;
    // 解码又转码并不矛盾，php和js编码效果并不一致
    $encode_dir = urlencode($base_dir);
    
    $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?method=listall&path=$encode_dir&access_token=$access_token&order=name&recursion=1&limit=$limit";
    
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'USER-AGENT: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    errmsg_file_get_content($opts);

    $json = json_decode($result);
    
    $pathStr = explode("/",$base_dir); // 字符串/分割的数组
    $base_dir_count = count($pathStr);  // 根目录层级，只记录数量
    $lastPath = $pathStr[count($pathStr)-1];
    
    // 拼接字符串，最终一次性输出
    $str =  "<h2>资源生成树展示：$lastPath";
    $all_size = 0;
    
    // 提取目录
    $dir_arr = [];
    $dir_arr[$base_dir] = ['name'=>$lastPath,'deep'=>1,'size'=>0];
    foreach ($json->list as $row){
        if($row->isdir){
            
            // 生成子目录info
            $deep = count(explode("/",$row->path))-$base_dir_count+1;  // 计算子目录层级数
            
            $dir_info = ['name'=>$row->server_filename,'deep'=>$deep,'size'=>0,'parent'=>0];
            
            $dir_arr[$row->path] = $dir_info;
        }
    }
    // 为每个目录寻找父目录，并记录最大层次
    $max_dir=0;
    foreach($dir_arr as $key=>$value)
    {
        // 并记录最大层次
        if($max_dir<$value['deep']){
            $max_dir=$value['deep'];
        }
        // 初始化大小为0
        $dir_arr[$key]['size']=0;
        // 2层以下的父目录均为base_dir
        if($value['deep']<=2){
            $dir_arr[$key]['parent'] = $base_dir;
        }
        // 3层以上的父目录，需要手动寻找上一层
        else{
            // 遍历找出上一层的所有目录
            $before = $value['deep']-1;
            $before_arr = [];
            foreach($dir_arr as $key2=>$value2)
            {
                if($value2['deep']==$before){
                    $before_arr[$key2] = $value2;
                }
            }
            // 遍历该目录，如果该目录中任意一个被当前包含，则说明是当前父目录
            foreach($before_arr as $key3=>$value3)
            {
                if(strpos($key,$key3)!==false){
                    $dir_arr[$key]['parent'] = $key3;
                }
            }
        }
    }
    // 开始重新排序目录
    $dir_sort = [];
    
    $dir_sort[$base_dir] = $dir_arr[$base_dir];
    
    foreach($dir_arr as $key=>$value)
    {
        //从第2层开始，如果有子目录，并找到其子目录
        $start_loop = 2;
        if($value['deep']==$start_loop){
            
            // 把第2层加入
            $dir_sort[$key] = $dir_arr[$key];
            autoCeil($dir_arr,$start_loop,$key,$dir_sort,$max_dir);
        }
    }
    // 递归添加层数
    function autoCeil($dir_arr,$start_loop,$key,$dir_sort,$max_dir){
        global $dir_sort;
        if($start_loop>$max_dir){
            return;
        }
        foreach($dir_arr as $key2=>$value2)
        {
            // 查询第三层中，和当前第2层符合父子关系的目录
            if($value2['deep']==$start_loop+1 && $key==$value2['parent']){
                
                $dir_sort[$key2] = $dir_arr[$key2];
                autoCeil($dir_arr,$start_loop+1,$key2,$dir_sort,$max_dir);
            }
        }
    }
    // 目录排序完毕
    $dir_arr = $dir_sort;
    // 给文件夹添加文件，并计算文件夹大小
    foreach ($json->list as $row){
        
        if(!$row->isdir){
            // 累计根目录文件夹总大小
            $all_size += $row->size;
            // 查找文件最后一个 / ，以识别它所在的目录
            $index = strrpos($row->path,"/");
            $dir_path = substr($row->path,0,$index);
            // 根据它所在的目录，累计其文件夹大小
            $dir_arr[$dir_path]['size'] += $row->size;
            // 根据所在目录，把文件添加到其list属性中
            $dir_arr[$dir_path]['list'][$row->server_filename] = $row->size;
            
        }
    }
    // 累计父文件夹的大小，由于php本身数据缓存问题，这里需要分层
    fixedDir($dir_arr,$max_dir,$max_dir);
    function fixedDir($dir_arr,$current,$max_dir){
        global $dir_arr;
        if($current<1){
            return;
        }else{
            // 让当前层次的所有大小添加到其父目录中去
            foreach($dir_arr as $key=>$value)
            {
                if($value['deep']==$current && $value['parent']!=$key){
                    $dir_arr[$value['parent']]['size'] += $value['size'];
                }
            }
        }
        fixedDir($dir_arr,$current-1,$max_dir);
    }
    //根文件夹总大小
    $str .= " [ ".height_show_size($all_size)." ]</h2>";
    
    foreach($dir_arr as $key=>$value)
    {
        // 根目录下的文件
        if($key==$base_dir){
            if(isset($value['list'])){
                foreach ($value['list'] as $fileName=>$fileSize){
                    $str .= "<p>┣━  ".$fileName." <b>[ ".height_show_size($fileSize)." ]</b> </p>";
                }
            }
        }
        // 子目录下的文件
        else{
            // 拼接子目录样式
            $son_str = "";
            $son_flag ="┃ ";
            $deep = $value['deep'];
            for($i=2;$i<$deep;$i++){
                $son_str .= $son_flag;
            }
            $son_str .= "┣━";
            $son_file_str = $son_flag.$son_str;
            
            $str .= "<h4>$son_str  ".$value['name']." <b>[ ".height_show_size($value['size'])." ]</b> </h4>";
            
            // 拼接子目录文件样式
            if(isset($value['list'])){
                foreach ($value['list'] as $fileName=>$fileSize){
                    $str .= "<p>$son_file_str  ".$fileName." <b>[ ".height_show_size($fileSize)." ]</b ></p>";
                } 
            }
        }
    }
    
    echo $str;
    
?>


<style>
    p{
        margin: 0;
        word-break: break-all;
    }
    h4{
        margin-top: 10px;
        margin-bottom: 10px;
    }
</style>